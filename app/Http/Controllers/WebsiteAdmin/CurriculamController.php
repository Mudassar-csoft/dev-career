<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\Curriculam;
use App\Models\WebsiteAdmin\WebsiteCourse;

class CurriculamController extends Controller
{
    
        public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Curriculum";
        $course_active = "active";
        $course_open = "open";
        $curriculums = "active";

        $curriculum = Curriculam::with('course')->get();
        return view('WebsiteAdmin.Curriculum.index',compact('title','curriculum', 'course_active', 'course_open', 'curriculums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = WebsiteCourse::all();
        $title = "Add Curriculum";
        $course_active = "active";
        $course_open = "open";
        $curriculums = "active";
        return view('WebsiteAdmin.Curriculum.create',compact('title','course', 'course_active', 'course_open', 'curriculums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curriculum =  new Curriculam();
        $curriculum->title = $request->title;
        $curriculum->course_id = $request->course_id;
        $curriculum->duration = $request->duration;
        $curriculum->tool = $request->tool;
        $curriculum->description = $request->description;
        $curriculum->save();
        return redirect('curriculum')->with([
            'message' => ' Curriculum Add successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curriculum = Curriculam::find($id)->delete();
        return redirect('curriculum')->with([
            'message' => ' Curriculum Delete successfully!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Curriculum";
        $course_active = "active";
        $course_open = "open";
        $curriculums = "active";
        $curriculum = Curriculam::find($id);
        $updatecourse = WebsiteCourse::all();
        return view('WebsiteAdmin.Curriculum.update',compact('title','updatecourse','curriculum', 'course_active', 'course_open', 'curriculums'));
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


        $curriculum = Curriculam::find($id);
        $curriculum->title = $request->title;
        $curriculum->course_id = $request->course_id;
        $curriculum->duration = $request->duration;
        $curriculum->tool = $request->tool;
        $curriculum->description = $request->description;
        $curriculum->save();
        return redirect('curriculum')->with([
            'message' => ' Curriculum Update successfully!'
        ]);

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
