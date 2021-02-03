<?php

namespace App\Http\Controllers;

use App\Mail\ProjectStatusUpdateEmail;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\ProjectStatusUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectStatusUpdateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * function to update a project with a new status.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
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
                    $allowedStatus = array("completed", "further-changes-required", "in-progress", "submitted-for-review");
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
                                $altFileNameToStore = md5($filename . '' . rand()) . '_' . time() . '.' . $extension;


                                if (Auth::user()->id === $project->worker_id) {
                                    //watermark all images or files

                                    $imageMimeArray = ['image/*', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                                    //if the file is an image

                                    $pdfArray = ['application/pdf'];
                                    if (in_array($file->getMimeType(), $imageMimeArray)) {

                                        $path = $this->watermarkPhoto($file, 'public/projects/' . $project->id . '/attachments/watermarked',
                                            $fileNameToStore);


                                    }
                                    $path = $file->storeAs('public/projects/' . $project->id . '/attachments', $altFileNameToStore);


                                } else {
                                    $path = $file->storeAs('public/projects/' . $project->id . '/attachments', $fileNameToStore);

                                }


                                if ($path) {
                                    $attachment = new Attachment();
                                    $attachment->user_id = Auth::user()->id;
                                    $attachment->project_id = $project->id;
                                    $attachment->belongs_to_status_update = true;
                                    $attachment->status_update_id = $statusUpdate->id;
                                    $attachment->name = $filenameWithExt;

                                    if (Auth::user()->id === $project->worker_id) {
                                        $attachment->location = '/storage/projects/' . $project->id . '/attachments/watermarked/' . $fileNameToStore;
                                        $attachment->original_file_location = '/storage/projects/' . $project->id . '/attachments/' . $altFileNameToStore;
                                        $attachment->is_water_marked = true;

                                    } else {
                                        $attachment->location = '/storage/projects/' . $project->id . '/attachments/' . $fileNameToStore;

                                    }


                                    $attachment->size = $file->getSize();
                                    $attachment->format = $file->getMimeType();
                                    $attachment->save();
                                }

                            }

                        }

                        $project->fresh();



                        if (Auth::user()->id === $project->worker_id) {

                            Mail::to($project->user->email)->queue(new ProjectStatusUpdateEmail($statusUpdate,
                                $project, 'worker'));
                        }else if(Auth::user()->id === $project->user->id){



                            Mail::to($project->worker->email)->queue(new ProjectStatusUpdateEmail($statusUpdate,
                                $project,'employer'));
                        }
                        //make it realtime
                        return response()->json(['success' => true,  'message' => 'project status updated successfully',
                            'project' => $project, 'status_update' =>
                            $statusUpdate], 200);

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


    /**
     * get status updates for a project.
     *
     * @param Project $project
     * @return void
     */
    public function index(Project $project)
    {
        $statusUpdates = $project->statusUpdates()->latest();
    }


    /**
     * watermarking an image/photo.
     *
     * @param $imgFile
     * @param $pathToSaveFile
     * @param $fileNameToSave
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function watermarkPhoto($imgFile, $pathToSaveFile, $fileNameToSave)
    {

        $originalExtension = $imgFile->getClientOriginalExtension();

        $watermark_path = Storage::disk('private')->get('watermark/pattern.png');


        $watermarkImg = Image::make($watermark_path);

        $img = Image::make($imgFile);

        $wmarkWidth = $watermarkImg->width();
        $wmarkHeight = $watermarkImg->height();

        $imgWidth = $img->width();
        $imgHeight = $img->height();

        $x = 0;
        $y = 0;
        while ($y <= $imgHeight) {
            $img->insert($watermark_path, 'top-left', $x, $y);
            $x += $wmarkWidth;
            if ($x >= $imgWidth) {
                $x = 0;
                $y += $wmarkHeight;
            }
        }

        Storage::put($pathToSaveFile . "/" . $fileNameToSave, $img->encode($originalExtension));


        //$img->save($filePath2Save);

        $watermarkImg->destroy();
        $img->destroy();

        return $pathToSaveFile;
    }


}
