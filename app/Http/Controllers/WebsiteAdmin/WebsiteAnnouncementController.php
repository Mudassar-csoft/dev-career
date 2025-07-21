<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\Announcement;
use Illuminate\Support\Facades\Validator;

class WebsiteAnnouncementController extends Controller
{
    public function index()
    {
        $title = "News";
        $new = 'active';
        $announc = Announcement::all();
        return view('WebsiteAdmin.News.index',compact('title','new','announc'));
    }

    public function create()
    {
        $title = "Create";
        $new = 'active';
        return view('WebsiteAdmin.News.create',compact('title','new'));

    }
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(),[

            'title'=> 'required',
            'image'=> 'required|dimensions:max_width=180,max_height=180',
            'publishdata'=> 'required',
            'validata'=> 'required',
            'description'=> 'required',

        ]);
        if($validate->fails()){
                return redirect()->back()->with([
                    'message' => 'Something went wrong!!'
                ])->withErrors($validate)->withInput();
        }
        $announc = new Announcement();
        if($request->hasFile('image')){
            $path = asset('storage/'. $request->image->store('announcement'));
            $announc->image = $path;
        }
        $announc->title = $request->title;
        $announc->publish_date = $request->publishdata;
        $announc->valid_date = $request->validata;
        $announc->description = $request->description;
        $announc->save();
        return redirect()->route('website.news')->with([
            'message' => 'News Added Successfully!'
        ]);


    }

    public function edit($id)
    {
        $title = "Edit";
        $new = 'active';
        $annouid = Announcement::find($id);
        return view('WebsiteAdmin.News.edit',compact('annouid','title','new'));


    }


    public function update( Request $request)
    {

        // $validate = Validator::make($request->all(),[

        //     'title'=> 'required',
        //     'image'=> 'required',
        //     'publishdata'=> 'required',
        //     'validata'=> 'required',
        //     'description'=> 'required',

        // ]);
        // if($validate->fails()){
        //         return redirect()->back()->with([
        //             'message' => 'Something went wrong!!'
        //         ])->withErrors($validate)->withInput();
        // }
        //  dd($request);
        $id = $request->updateid;
        $announc = Announcement::find($id);
        if($request->hasFile('image')){
            $paths = asset('storage/'. $request->image->store('announcement'));
            $announc->image = $paths;
        }
        $announc->title = $request->title;
        $announc->publish_date = $request->publishdata;
        $announc->valid_date = $request->validata;
        $announc->description = $request->description;
        $announc->save();
        return redirect()->route('website.news')->with([
            'message' => 'News Update Successfully!'
        ]);


    }

    public function destory($id)
    {
        $annouid = Announcement::find($id)->delete();
        return redirect()->route('website.news')->with([
            'message' => 'News Delete Successfully!'
        ]);



    }
}
