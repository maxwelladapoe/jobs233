<?php

namespace App\Http\Controllers;

use App\Events\ProjectPosted;
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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'read', 'getProjects', 'readProject', 'getCategories', 'getCategoriesAndSkills', 'getSkills');

    }


    /**
     * Get all Projects (projects that are not assigned).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index(Request $request)
    {

        //check if there is an assigned to


        if ($request->has('status')) {
            $query = Project::where('status', $request['status']);
        } else {
            $query = Project::latest();
            //$query->where('status','<>', 'Completed');
        }


        //check if there is a created by

        if ($request->has('owner')) {
            $query->where('user_id', Auth::user()->id);
        }

        if ($request->has('assigned_to')) {
            $query->where('worker_id', Auth::user()->id);
        }

//        if (!$request->has('owner') || !$request->has('assigned_to')) {
//            $query->where('status', 'new');
//        }



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


    /**
     * Create a project.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
            'skills' => ['nullable','string'],
            'tags' => ['nullable','string'],
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
            $project->status = 'new';


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

                        $path = $file->storeAs('public/projects/' . $project->id . '/attachments', $fileNameToStore);

                        if ($path) {
                            $attachment = new Attachment();
                            $attachment->user_id = Auth::user()->id;
                            $attachment->project_id = $project->id;
                            $attachment->name = $filenameWithExt;
                            $attachment->location = '/storage/projects/' . $project->id . '/attachments/' . $fileNameToStore;
                            $attachment->size = $file->getSize();
                            $attachment->format = $file->getMimeType();
                            $attachment->save();
                        }

                    }

                }

                broadcast(new ProjectPosted($project))->toOthers();
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




    /**
     * Read/view a project.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function read(Request $request)
    {
        $project = Project::where('id', $request->project)->with('bids')->first();
        return response()->json(['success' => true, 'project' => $project], 200);
    }


    /**
     * Update a project.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Project $project, Request $request)
    {

        if ($project->user->id === Auth::user()->id) {

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


            if (!$project->worker_id || !$project->accepted_bid_id) {

                $project->title = $request['title'];
                $project->description = $request['description'];
                $project->additional_details = $request['additional_details'];
                $project->user_id = Auth::user()->id;
                $project->category_id = $request['category'];
                $project->budget = doubleval($request['budget']);
                $project->balance = doubleval($request['budget']);
                $project->currency_id = $request['currency_id'];
                $project->secondary_category_id = $request['subcategory'];
                $project->skills = $request['skills'];
                $project->tags = $request['tags'];
                $project->deadline = $request['deadline'];
                // $project->status = 'new';


                if ($project->save()) {


                    Mail::to(Auth::user()->email)->queue(new ProjectCreatedSuccessfully($project));

                    return response()->json(['success' => true, 'project' => $project, 'message' => 'Your project has been updated successfully'], 200);
                } else {
                    Log::debug("there seems to be an issue with project update. you may have to check the database");
                    return response()->json(['success' => false, 'message' => 'the project update failed'], 500);
                }


            } else {


                return response()->json(['success' => false, 'message' => 'this project is already assigned'], 500);

            }

        }
        else {
            return response()->json(['success' => false, 'message' => 'unauthorised'], 401);
        }

    }




    /**
     * Function to mark a project as completed.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function markProjectAsCompleted(Request $request)
    {

        //this function is responsible for handling status updates

        $this->validate($request, [
            'project_id' => ['required'],
        ]);

        $project = Project::find($request->project_id);


        if ($project) {


            if ($project->user_id == Auth::user()->id) {

                if ($project->payment_concluded == true && $project->balance == 0) {

                    if ($project->worker_payed == true) {
                        return response()->json(['success' => false, 'message' => 'worker has already been payed'], 401);

                    } else {

                        if (Auth::user()->wallet->balance > $project->balace)
                        $statusUpdate = new ProjectStatusUpdate();
                        $statusUpdate->project_id = $project->id;
                        $statusUpdate->status = "completed";
                        $statusUpdate->message = "Project Completed";
                        if ($statusUpdate->save()) {

                            $project->status = "completed";
                            $project->worker_payed = true;
                            $project->save();
                            $project->fresh();
                            $this->payWorker($project);


                            return response()->json(['success' => true, 'project' => $project], 200);
                        } else {
                            Log::debug("there seems to be an issue with project status creation. you may have to check the database");
                            return response()->json(['success' => false, 'message' => 'oops something went wrong with the status creation'], 500);
                        }


                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'please conclude payments for this project'], 401);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'unauthorised'], 401);
            }


        } else {
            return response()->json(['success' => false, 'message' => 'The project you are looking for does not exist'], 400);

        }


    }


    /**
     * Function to pay a worker.
     *
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function payWorker(Project $project)
    {
        if (Auth::user() && Auth::user()->id === $project->user_id) {
            //if the project is marked as completed
            if ($project->status === 'completed') {
                // proceed to release funds to the creative

                $employer = User::find($project->user_id);
                $worker = User::find($project->worker_id);

                $acceptedBid = Bid::find($project->accepted_bid_id);

                $finalAgreedOffer = doubleval($acceptedBid->amount);


                if ($employer->wallet->balance >= $finalAgreedOffer) {
                    if (doubleval($project->balance) <= 0 || doubleval($project->balance) <= 0.00) {


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
                    return response()->json(['success' => false, 'message' => 'you do not have enough balance to perform this transation'], 401);

                }

                //the accepted bid offer


            } else {
                return response()->json(['success' => false, 'message' => 'project is not completed'], 401);

            }
        }
    }



    /**
     * Delete a Project
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function delete(Request $request)
    {

        $project = Project::findOrFail($request['id']);

        if ($project->user_id == Auth::user()->id) {

            if ($project->status == 'new' && $project->accepted_bid == null && $project->worker_id == null) {
                //then you can delete
                //$project->delete();
                $attachments = $project->attachments();

                dd($attachments);
                foreach ($attachments as $attachment) {
                    //delete each record
                }
            }

        } else {
            return response()->json(['success' => false, 'message' => 'this project does not belong to you'], 401);
        }

    }


    /**
     * Get a specific assigned Project.
     *
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
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


    /**
     * Get all assigned Projects to authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssignedProjects()
    {
        $projects = Project::where('worker_id', Auth::user()->id)
            ->orWhere('user_id', Auth::user()->id)
            ->where('status', '<>', 'completed')->orderby('updated_at', 'desc')->paginate(10);

        return response()->json(['success' => true, 'projects' => $projects], 200);

    }


    /**
     * Get all Categories & Skills.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriesAndSkills()
    {
        $categories = ProjectCategory::with(['subcategories'])->get();
        $skills = Skill::all();
        return response()->json(['success' => true, 'categories' => $categories, 'skills' => $skills], 200);
    }



    /**
     * Get all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function getCategories()
    {
        $categories = ProjectCategory::with(['subcategories'])->get();
        return response()->json(['success' => true, 'categories' => $categories], 200);
    }


    /**
     * Get all skills.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function getSkills()
    {
        $skills = Skill::all();
        return response()->json(['success' => true, 'skills' => $skills], 200);
    }


    /**
     * function to handle searching.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            "term" => ['required']
        ]);

        $projects = Project::search($request->term)->get();
        return response()->json(['success' => true, 'projects' => $projects], 200);


    }


}
