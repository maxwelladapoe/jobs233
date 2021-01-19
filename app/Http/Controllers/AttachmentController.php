<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'project_id' => ['required'],
            'attachments' => ['required'],
        ]);


        $project = Project::findOrFail($request['project_id']);
        if ($project->user_id === Auth::user()->id) {


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

                $project = $project->fresh();

                $pluralizeFilesCount = Str::plural('file', count($files));
                return response()->json(['success' => true,
                    'message' => 'your ' . $pluralizeFilesCount . ' were uploaded successfully',
                    'attachments' => $project->attachments
                ], 201);

            }
        }
    }

    public function delete(Attachment $attachment)
    {


        if ($attachment->user_id === Auth::user()->id) {
            //you can delete

            //get the location /path


            $fda = explode('/', $attachment->location);
            $fd = end($fda);
            Storage::delete('public/attachments/' . $fd);

            if ($attachment->delete()) {
                return response()->json(['success' => true,
                    'message' => 'attachment deleted successfully'], 201);
            }
        }
    }

}
