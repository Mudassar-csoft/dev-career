<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Models\WebsiteAdmin\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WebsiteAdmin\WebsiteCourse;

class FAQController extends Controller
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
        $title = "FAQ's";
        $course_active = "active";
        $course_open = "open";
        $faqs = "active";
        $faqss = Faq::with('course')->get();
        return view('WebsiteAdmin.course.Faq.index', compact('title', 'course_active', 'course_open', 'faqs', 'faqss'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add FAQ";
        $course_active = "active";
        $course_open = "open";
        $faqs = "active";
        $courses = WebsiteCourse::all();
        return view('WebsiteAdmin.course.Faq.create', compact('title', 'course_active', 'course_open', 'faqs', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_course_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->with([
                'message' => 'Something went wrong!'
            ])->withInput();
        }else{
            $faq = new Faq();
            $faq->title = $request->title;
            $faq->description = $request->description;
            $faq->website_course_id = $request->website_course_id;
            $faq->save();
            return redirect()->route('faqs.index')->with([
                'message' => 'FAQ added successfully!'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faq = Faq::find($id)->delete();
        return redirect()->route('faqs.index')->with([
            'message' => 'Deleted Successfully!'
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
        $title = "Edit FAQ";
        $course_active = "active";
        $course_open = "open";
        $faqs = "active";
        $courses = WebsiteCourse::all();
        $faq = Faq::find($id);
        return view('WebsiteAdmin.course.Faq.edit', compact('title', 'course_active', 'course_open', 'faqs', 'courses', 'faq'));
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
        $validator = Validator::make($request->all(), [
            'website_course_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->with([
                'message' => 'Something went wrong!'
            ])->withInput();
        }else{
            $faq = Faq::find($id);
            $faq->title = $request->title;
            $faq->description = $request->description;
            $faq->website_course_id = $request->website_course_id;
            $faq->save();
            return redirect()->route('faqs.index')->with([
                'message' => 'FAQ updated successfully!'
            ]);
        }
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