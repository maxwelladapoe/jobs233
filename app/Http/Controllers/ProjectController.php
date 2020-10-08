<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth')->except('read', 'getProjects', 'readProject', 'getCategories', 'getCategoriesAndSkills', 'getSkills');;

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
            'skills' => ['nullable'],
            'tags' => ['nullable'],
            'deadline' => ['date'],

        ]);

        $projectExists = Project::where('user_id', Auth::user()->id)->where('title', $request['title'])->where('status', 'created')->where('description', $request['description'])->get();


        if ($projectExists->count() == 0) {


            $project = new Project();
            $project->title = $request['title'];
            $project->description = $request['description'];
            $project->additional_details = $request['additional_details'];
            $project->user_id = Auth::user()->id;
            $project->category_id = $request['category'];
            $project->budget = number_format($request['budget'], 2);
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

                return response()->json(['success' => true, 'project' => $project, 'message' => 'Your project has been created successfully'], 200);
            } else {
                Log::debug("there seems to be an issue with project creation. you may have to check the database");
                return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);
            }


        } else {


            return response()->json(['success' => false, 'message' => 'this project already exists'], 500);

        }


    }

    public function read(Project $project)
    {

        return response()->json(['success' => true, 'project' => $project], 200);

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function getProjects()
    {
        $projects = Project::where('status', 'created')->orderby('created_at', 'desc')->paginate(10);

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


}
