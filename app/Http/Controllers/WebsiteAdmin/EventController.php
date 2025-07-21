<?php

namespace App\Http\Controllers\WebsiteAdmin;

use App\Models\Campus;
use Illuminate\Http\Request;
use App\Models\WebsiteAdmin\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function index()
    {
        $title = "Event";
        $event = 'active';
        $allevent = Event::with('campus')->get();
        return view('WebsiteAdmin.Event.index',compact('title','event','allevent'));
    }

    public function create()
    {

        $title = "Event";
        $event = 'active';
        $campuses = Campus::all();
        return view('WebsiteAdmin.Event.create',compact('title','event','campuses'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'campus_id' => 'required',
            'title' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'event_days' => 'required',
            'description' => 'required',
        ]);
        
        if ($validate->fails()) {
            return redirect()->back()->with([
                'message' => 'Something went wrong!!'
            ])->withErrors($validate)->withInput();
        }
        
        $event = new Event();
        
        // Handle first image
        if ($request->hasFile('first_image')) {
            $firstImage = $request->file('first_image');
        
            // Define the target directory and file name
            $targetDirectory = 'event';
            $firstImageName = time() . '_' . $firstImage->getClientOriginalName();
            $firstImagePath = $targetDirectory . '/' . $firstImageName;
        
            // Move the uploaded file to the specified directory
            $firstImage->move(public_path('storage/' . $targetDirectory), $firstImageName);
        
            // Update the model with the file path
            $event->first_image = $firstImagePath;
        }
        
        // Handle second image
        if ($request->hasFile('second_image')) {
            $secondImage = $request->file('second_image');
        
            // Define the target directory and file name
            $targetDirectory = 'event';
            $secondImageName = time() . '_' . $secondImage->getClientOriginalName();
            $secondImagePath = $targetDirectory . '/' . $secondImageName;
        
            // Move the uploaded file to the specified directory
            $secondImage->move(public_path('storage/' . $targetDirectory), $secondImageName);
        
            // Update the model with the file path
            $event->second_image = $secondImagePath;
        }
        
        $event->title = $request->title;
        $event->seo_title=$request->seo_title;
        $event->seo_discription=$request->seo_discription;
        $event->event_color=$request->event_color;
        $event->alt_1=$request->alt_1;
        $event->alt_2=$request->alt_2;

        $event->campus_id = $request->campus_id;
        $event->event_time = $request->event_time;
        $event->event_date = $request->event_date;
        $event->event_days = $request->event_days;
        $event->description = $request->description;
        $event->save();
        
        return redirect()->route('website.event')->with([
            'message' => 'Event submitted successfully!'
        ]);
        






    }

    public function edit($id)
    {
        $eventid = Event::find($id);
        $title = "Event";
        $event = 'active';
        $campuses = Campus::all();
        return view('WebsiteAdmin.Event.edit',compact('title','event','campuses','eventid'));
    }


    public function update( Request $request)
    {


        $validate = Validator::make($request->all(), [
            'campus_id'=>'required',
            'title' => 'required',
            'event_date'=>'required',
            'event_time'=>'required',
            'description'=>'required',
            'id'=>'required',

        ]);
        if($validate->fails()){
            return redirect()->back()->with([
                'message' => 'Something went wrong!!'
                ])->withErrors($validate)->withInput();
            }
        if($validate->fails()){
            return redirect()->back()->with([
                'message' => 'Something went wrong!!'
                ])->withErrors($validate)->withInput();
            }

        $event =  Event::find($request->id);

  if ($request->hasFile('first_image')) {
            $firstImage = $request->file('first_image');
        
            // Define the target directory and file name
            $targetDirectory = 'event';
            $firstImageName = time() . '_' . $firstImage->getClientOriginalName();
            $firstImagePath = $targetDirectory . '/' . $firstImageName;
        
            // Move the uploaded file to the specified directory
            $firstImage->move(storage_path('app/public/' . $targetDirectory), $firstImageName);
        
            // Update the model with the file path
            $event->first_image = $firstImagePath;
        }
        
        // Handle second image
        if ($request->hasFile('second_image')) {
            $secondImage = $request->file('second_image');
        
            // Define the target directory and file name
            $targetDirectory = 'event';
            $secondImageName = time() . '_' . $secondImage->getClientOriginalName();
            $secondImagePath = $targetDirectory . '/' . $secondImageName;
        
            // Move the uploaded file to the specified directory
            $secondImage->move(storage_path('app/public/' . $targetDirectory), $secondImageName);
        
            // Update the model with the file path
            $event->second_image = $secondImagePath;
        }


        $event->title = $request->title;
        $event->seo_title=$request->seo_title;
        $event->seo_discription=$request->seo_discription;
        $event->event_color=$request->event_color;
        $event->alt_1=$request->alt_1;
        $event->alt_2=$request->alt_2;
        $event->campus_id = $request->campus_id;
        $event->event_days = $request->event_days;
        $event->event_time = $request->event_time;
        $event->event_date = $request->event_date;
        $event->description = $request->description;
        $event->save();
        return redirect()->route('website.event')->with([
            'message' => 'Event Update successfully!'
        ]);


    }

    public function destory($id)
    {
        $gallery = Event::find($id)->delete();
        return redirect()->route('website.event')->with([
            'message' => 'Event Delete successfully!'
        ]);


    }

}
