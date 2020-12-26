<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PortfolioItemController extends Controller
{


    public function getAll(){

        if (Auth::user()){
            $allowedPreferenceArray = ['work', 'work&hire'];

            if (in_array(strtolower(Auth::user()->profile->preference), $allowedPreferenceArray
            )){
                return response()->json(['success' => true,
                    'portfolio' => Auth::user()->portfolio], 200);
            }
        }else{

        }
    }
    public function create(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:3'],
            'cover_image' => ['required', 'image'],
            'category_id' => ['nullable'],
            'secondary_category_id' => ['nullable'],
            'skills_and_tools' => ['required']
        ]);


        $portfolioItem = new PortfolioItem();


        if (Auth::user()) {


            $allowedPreferenceArray = ['work', 'work&hire'];


            if (in_array(strtolower(Auth::user()->profile->preference), $allowedPreferenceArray
            )) {

                $portfolioItem->user_id = Auth::user()->id;
                $portfolioItem->category_id = $request['category_id'];
                $portfolioItem->secondary_category_id = $request['secondary_category_id'];
                $portfolioItem->name = $request['name'];
                $portfolioItem->description = $request['description'];
                $portfolioItem->skills_and_tools = $request['skills_and_tools'];


                // Handle file Upload
                if ($request->hasFile('cover_image')) {

                    // Get filename with the extension
                    $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $request->file('cover_image')->getClientOriginalExtension();
                    // Filename to store

                    $finalExtension = 'webp';
                    $fileNameToStore = md5($filename) . '_' . time() . '.' . $finalExtension;
                    // Upload Image

                    $image = Image::make($request->file('cover_image'))->encode($finalExtension);


                    $store = Storage::put('public/portfolio/cover_images/' . $fileNameToStore, $image);


                    $portfolioItem->cover_image = '/storage/portfolio/cover_images/' . $fileNameToStore;


                }


                if ($portfolioItem->save()) {
                    return response()->json(['success' => true,
                        'message' => 'portfolio item added successfully',
                        'item' => $portfolioItem], 201);
                }


            } else {
                return response()->json(['success' => false, 'message' => 'you can not create a profile with your role'],
                    401);

            }
        } else {
            return response()->json(['success' => false, 'message' => 'you are not authorised to perform this action'],
                401);
        }

        /*
         *
         *        $table->bigInteger('user_id');
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('secondary_category_id')->nullable();
            $table->string('name');
            $table->string('description');
            $table->string('type');
            $table->string('cover_image');
         */
    }


    public function delete(PortfolioItem $portfolioItem ){


        if (Auth::user()){

            if ($portfolioItem && Auth::user()->id ===$portfolioItem->user_id){
                //delete the ITEM

                //delete the cover image

                if ($portfolioItem->cover_image) {
                    $fda = explode('/', $portfolioItem->cover_image);
                    $fd = end($fda);
                    Storage::delete('public/portfolio/cover_images/' . $fd);

                }

                if($portfolioItem->delete()){
                    return response()->json(['success' => true,
                        'message' => 'portfolio item deleted successfully'], 200);
                }
            }else{
                return response()->json(['success' => false,
                    'message' => 'this item does not belong to your profile'], 401);
            }
        }else{
            return response()->json(['success' => false,
                'message' => 'you are not authorised to perform this action'], 401);
        }
    }

}
