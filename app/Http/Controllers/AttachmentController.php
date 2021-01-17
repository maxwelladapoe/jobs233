<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function delete(Attachment $attachment)
    {


        if ($attachment->user_id === Auth::user()->id) {
            //you can delete

            //get the location /path


            $fda = explode('/', $attachment->location);
            $fd = end($fda);
            Storage::delete('public/attachments/' . $fd);

            if($attachment->delete()){
                return response()->json(['success' => true,
                    'message' => 'attachment deleted successfully'], 201);
            }
        }
    }

}
