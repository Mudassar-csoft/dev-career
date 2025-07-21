<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Course Category";
        $category = CourseCategory::all();
        return view('WebsiteAdmin.course-category.index', compact('title', 'category'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Course Category";

        return view('WebsiteAdmin.course-category.create', compact('title'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = CourseCategory::updateOrCreate(['id' => $request->id], $request->all());
        return redirect('/coursecategory')->with([
            'message' => 'Requests submitted successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Course Category";
        $category = CourseCategory::find($id);
        return view('WebsiteAdmin.course-category.create', compact('title', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseCategory $courseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the course category by ID and delete it
        $category = CourseCategory::find($id);
        
        if ($category) {
            $category->delete(); // Delete the category if it exists
            return redirect()->route('coursecategory.index')->with('message', 'Category deleted successfully!');
        } else {
            return redirect()->route('coursecategory.index')->with('error', 'Category not found!');
        }
    }
}
