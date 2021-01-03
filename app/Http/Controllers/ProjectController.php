<?php

namespace App\Http\Controllers;

use App\Mail\ProjectCreatedSuccessfully;
use App\Models\Attachment;
use App\Models\Bid;
use App\Models\Currency;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectPayment;
use App\Models\ProjectStatusUpdate;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth')->except('read', 'getProjects', 'readProject', 'getCategories', 'getCategoriesAndSkills', 'getSkills');

    }


    public function create(Request $request)
    {


        $this->validate($request, [
            'title' => ['string', 'required', 'min:3', 'max:150'],
            'description' => ['string', 'required', 'min:3', 'max:2000'],
            'category' => ['integer', 'required'],
            'subcategory' => ['integer', 'required'],
            'budget' => ['required', 'string'],
            'currency' => ['required', 'integer', 'min:1'],
            'additional_details' => ['nullable', 'string'],
            'skills' => ['required'],
            'tags' => ['nullable'],
            'deadline' => ['date', 'required'],

        ]);

        $projectExists = Project::where('user_id', Auth::user()->id)->where('title', $request['title'])->where('status', 'created')->where('description', $request['description'])->get();


        if ($projectExists->count() == 0) {

            $project = new Project();
            $project->title = $request['title'];
            $project->description = $request['description'];
            $project->additional_details = $request['additional_details'];
            $project->user_id = Auth::user()->id;
            $project->category_id = $request['category'];
            $project->budget = doubleval($request['budget']);
            $project->balance = doubleval($request['budget']);
            $project->currency_id = $request['currency'];
            $project->secondary_category_id = $request['subcategory'];
            $project->skills = $request['skills'];
            $project->tags = $request['tags'];
            $project->deadline = $request['deadline'];


            if ($project->save()) {


                if ($request->has('attachments')) {
                    $files = $request['attachments'];

                    foreach ($files as $file) {


                        $filenameWithExt = $file->getClientOriginalName();
                        //Get just filename
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        // Get just ext
                        $extension = $file->getClientOriginalExtension();
                        // Filename to store
                        $fileNameToStore = md5($filename) . '_' . time() . '.' . $extension;

                        $path = $file->storeAs('public/attachments', $fileNameToStore);

                        if ($path) {
                            $attachment = new Attachment();
                            $attachment->user_id = Auth::user()->id;
                            $attachment->project_id = $project->id;
                            $attachment->name = $filenameWithExt;
                            $attachment->location = '/storage/projects/' . $project->id . '/attachments/' . $fileNameToStore;;
                            $attachment->size = $file->getSize();
                            $attachment->format = $file->getMimeType();
                            $attachment->save();
                        }

                    }

                }

                Mail::to(Auth::user()->email)->queue(new ProjectCreatedSuccessfully($project));

                return response()->json(['success' => true, 'project' => $project, 'message' => 'Your project has been created successfully'], 200);
            } else {
                Log::debug("there seems to be an issue with project creation. you may have to check the database");
                return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);
            }


        } else {


            return response()->json(['success' => false, 'message' => 'this project already exists'], 500);

        }


    }

    public function read(Request $request)
    {
        $project = Project::where('id', $request->project)->with('bids')->first();
        return response()->json(['success' => true, 'project' => $project], 200);
    }

    public function update()
    {

    }

    public function updateStatus(Request $request)
    {

        //this function is responsible for handling status updates

        $this->validate($request, [
            'project_id' => ['required'],
            'status' => ['string', 'required'],
            'message' => ['string', 'required']

        ]);

        $project = Project::find($request->project_id);


        if ($project) {


            if ($project->worker_id == Auth::user()->id || $project->user_id == Auth::user()->id) {

                if ($project->worker_id == Auth::user()->id) {
                    $allowedStatus = array("in-progress", "submitted-for-review");
                } elseif ($project->user_id == Auth::user()->id) {
                    $allowedStatus = array("completed", "further-changes-required");
                }

                if (in_array($request->status, $allowedStatus)) {
                    $project->status = $request->status;
                    $project->save();

                    //attachments

                    $statusUpdate = new ProjectStatusUpdate();
                    $statusUpdate->project_id = $project->id;
                    $statusUpdate->status = $request->status;
                    $statusUpdate->message = $request->message;

                    if ($statusUpdate->save()) {


                        if ($request->has('attachments')) {
                            $files = $request['attachments'];

                            foreach ($files as $file) {


                                $filenameWithExt = $file->getClientOriginalName();
                                //Get just filename
                                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                // Get just ext
                                $extension = $file->getClientOriginalExtension();
                                // Filename to store
                                $fileNameToStore = md5($filename) . '_' . time() . '.' . $extension;

                                $path = $file->storeAs('public/attachments', $fileNameToStore);

                                if ($path) {
                                    $attachment = new Attachment();
                                    $attachment->user_id = Auth::user()->id;
                                    $attachment->project_id = $project->id;
                                    $attachment->belongs_to_status_update = true;
                                    $attachment->status_update_id = $statusUpdate->id;
                                    $attachment->name = $filenameWithExt;
                                    $attachment->location = '/storage/projects/' . $project->id . '/attachments/' . $fileNameToStore;;
                                    $attachment->size = $file->getSize();
                                    $attachment->format = $file->getMimeType();
                                    $attachment->save();
                                }

                            }

                        }


                        return response()->json(['success' => true, 'project' => $project], 200);

                    } else {
                        Log::debug("there seems to be an issue with project status creation. you may have to check the database");
                        return response()->json(['success' => false, 'message' => 'oops something went wrong with the status creation'], 500);
                    }


                } else {
                    return response()->json(['success' => false, 'message' => 'The status does not seem valid'], 500);

                }
            } else {
                return response()->json(['success' => false, 'message' => 'this project has not been assigned to this user or has not been assigned'], 401);

            }


        } else {
            return response()->json(['success' => false, 'message' => 'The project you are looking for does not exist'], 400);

        }


    }

    public function statusUpdates(Project $project)
    {
        $statusUpdates = $project->statusUpdates()->latest();
    }


    public function markProjectAsCompleted(Request $request)
    {

        //this function is responsible for handling status updates

        $this->validate($request, [
            'project_id' => ['required'],
        ]);

        $project = Project::find($request->project_id);


        if ($project) {


            if ($project->user_id == Auth::user()->id) {

                if ($project->payment_concluded == true || $project->balance == 0) {

                    if ($project->worker_payed == true) {
                        return response()->json(['success' => false, 'message' => 'worker has already been payed'], 401);

                    }
                    else {
                        $statusUpdate = new ProjectStatusUpdate();
                        $statusUpdate->project_id = $project->id;
                        $statusUpdate->status = "completed";
                        $statusUpdate->message = "Project Completed";
                        if ($statusUpdate->save()) {


                            $this->payWorker($project);

                            $project->status = "completed";
                            $project->worker_payed = true;
                            $project->save();

                            return response()->json(['success' => true, 'project' => $project], 200);
                        } else {
                            Log::debug("there seems to be an issue with project status creation. you may have to check the database");
                            return response()->json(['success' => false, 'message' => 'oops something went wrong with the status creation'], 500);
                        }
                    }
                }
                else {
                    return response()->json(['success' => false, 'message' => 'please conclude payments for this project'], 401);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'unauthorised'], 401);
            }


        } else {
            return response()->json(['success' => false, 'message' => 'The project you are looking for does not exist'], 400);

        }


    }

    public function payWorker(Project $project)
    {
        if (Auth::user() && Auth::user()->id === $project->user_id) {
            //if the project is marked as completed
            if ($project->status === 'completed') {
                // proceed to release funds to the creative

                if (doubleval($project->balance) <= 0 || doubleval($project->balance) <= 0.00) {

                    $employer = User::find($project->user_id);
                    $worker = User::find($project->worker_id);
                    //the accepted bid offer
                    $acceptedBid = Bid::find($project->accepted_bid_id);

                    $finalAgreedOffer = doubleval( $acceptedBid->amount);

                    $employer->withdraw($finalAgreedOffer);

                    //calculate the charge
                    $charges = $finalAgreedOffer * 0.1;
                    //admin user id
                    //add charge to admin user wallet

                    $amountPayableToWorker = $finalAgreedOffer - $charges;

                    $worker->deposit($amountPayableToWorker);
                    //double check if the last status update is completed *optional


                    $projectPayment = new ProjectPayment;
                    $projectPayment->project_id = $project->id;
                    $projectPayment->user_id = $worker->id;
                    $projectPayment->payment_id = "123456789";
                    $projectPayment->amount = $amountPayableToWorker;


                    $currencyDetails = Currency::where('name', 'GHS')->first();

                    $projectPayment->currency_id = $currencyDetails->id;
                    $projectPayment->balance_after = doubleval($worker->wallet->balance) + $amountPayableToWorker;
                    $projectPayment->type = 'Payment';
                    $projectPayment->description = 'Payment of' . $currencyDetails->name . ' ' . $amountPayableToWorker . ' for'
                        . $project->id;


                    if ($projectPayment->save()) {
                        return response()->json(['success' => true, 'worker' => $worker, 'message' => 'You have successfully paid for your project'], 200);
                    }

                } else {
                    return response()->json(['success' => false, 'message' => 'you need to complete payment / deposit for the project before you can release funds'], 401);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'project is not completed'], 401);

            }
        }
    }

    public function getLatestStatusUpdate(Request $request)
    {

    }


    public function delete()
    {

    }

    public function getProjects(Request $request)
    {

        //check if there is an assigned to


        if ($request->has('status')) {
            $query = Project::where('status', $request['status']);
        } else {
            $query = Project::latest();
        }


        //check if there is a created by

        if ($request->has('owner')) {
            $query->where('user_id', Auth::user()->id);
        }

        if ($request->has('assigned_to')) {
            $query->where('worker_id', Auth::user()->id);
        }

        if (!$request->has('owner') || $request->has('assigned_to')) {
            //$query->where('accepted_bid_id','<>', null);

        }

        //checking if a category key has been added
        if ($request->has('category')) {
            if ($request['category'] != 'all') {
                $categoryIds = ProjectCategory::whereIn('name', explode(',', $request['category']))->pluck('id');
                $query->whereIn('category_id', $categoryIds);
            }
        }


        //check if a sort key has been added
        if ($request->has('sort')) {
            $query->orderby('created_at', $request['sort']);
        } else {
            $query->orderby('created_at', 'desc');
        }


        if ($request->has('count')) {
            $projects = $query->take($request['count']);
        } elseif ($request->has('paginate')) {
            $projects = $query->paginate($request['paginate']);
        } else {
            $projects = $query->paginate(10);
        }

        return response()->json(['success' => true, 'projects' => $projects], 200);

    }

    public function getAssignedProject(Project $project)
    {


        if ($project->worker_id == Auth::user()->id || $project->user_id == Auth::user()->id) {

            $acceptedBid = Bid::find($project->accepted_bid_id);
            $statusUpdates = ProjectStatusUpdate::where('project_id', $project->id)->latest()->skip(1)->take(3)->get();
            $latestStatusUpdate = ProjectStatusUpdate::where('project_id', $project->id)->latest()->first();

            return response()->json(['success' => true,
                'project' => $project, 'accepted_bid' => $acceptedBid,
                'status_updates' => $statusUpdates,
                'latest_status_update' => $latestStatusUpdate], 200);


        } else {
            return response()->json(['success' => false, 'message' => 'this project has not been assigned to this user or has not been assigned'], 401);

        }

    }

    public function getAssignedProjects()
    {
        $projects = Project::where('worker_id', Auth::user()->id)->where('status', '<>', 'completed')->orderby('updated_at', 'desc')->paginate(10);

        return response()->json(['success' => true, 'projects' => $projects], 200);

    }

    public function getCategoriesAndSkills()
    {
        $categories = ProjectCategory::with(['subcategories'])->get();
        $skills = Skill::all();
        return response()->json(['success' => true, 'categories' => $categories, 'skills' => $skills], 200);
    }

    public function getCategories()
    {
        $categories = ProjectCategory::with(['subcategories'])->get();
        return response()->json(['success' => true, 'categories' => $categories], 200);
    }

    public function getSkills()
    {
        $skills = Skill::all();
        return response()->json(['success' => true, 'skills' => $skills], 200);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            "term" => ['required']
        ]);

        $projects = Project::search($request->term)->get();
        return response()->json(['success' => true, 'projects' => $projects], 200);


    }


}
