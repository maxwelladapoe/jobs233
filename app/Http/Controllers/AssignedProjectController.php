<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignedProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)

    {
        //check if there is an assigned to

        $query = Project::latest();

        //check if there is a created by


        if (!$request->has('owner') || $request->has('assigned_to')) {
            //$query->where('accepted_bid_id','<>', null);

        }

        if (Auth::user()->profile->proference =='work' ){
            $query->where('worker_id', Auth::user()->id);
        }elseif (Auth::user()->profile->proference =='hire' ){
            $query->where('user_id', Auth::user()->id);
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
