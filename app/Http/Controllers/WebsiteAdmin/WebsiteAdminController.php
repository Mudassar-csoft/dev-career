<?php

namespace App\Http\Controllers\WebsiteAdmin;

use App\Models\CourseCategory;
use App\Models\CourseWeek;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WebsiteAdmin\WebsiteCourse;
use Symfony\Component\Console\Input\Input;

class WebsiteAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function websiteDashboard()
    {
        $title = "Dashboard";
        $dash = 'active';

        return view('WebsiteAdmin.Dashboard.index', compact('title', 'dash'));
    }

    public function index()
    {
        $title = "Courses";
        $course = 'active';
        $websitecouse = WebsiteCourse::orderBy('id', 'DESC')->get();
        $category = CourseCategory::all();
        return view('WebsiteAdmin.course.index', compact('title', 'course', 'websitecouse', 'category'));
    }

    public function crete()
    {
        $title = "Create";
        $course = 'active';
        $category = CourseCategory::all();
        return view('WebsiteAdmin.course.create', compact('title', 'course', 'category'));
    }
    public function srote(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'pdffile' => 'required|file|max:10240', // Max: 10MB
            'description' => 'required',
            'type' => 'required',
            'title' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'lecture' => 'required|integer|min:1',
            'duration' => 'required|string|max:255',
            'session' => 'required|string|max:255',
            'feature' => 'required|string|max:255',
            'seo_discription' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'prerequisite' => 'nullable|string|max:255',
            'alt_1' => 'nullable|string|max:255',
            'second_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max: 2MB
            // 'weeklytitle.*' => 'required|string', // Validate each week title
            // 'weeklydescription.*' => 'required|string', // Validate each weekly description
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Handle the PDF file upload
        if ($request->hasFile('pdffile')) {
            $pdfpath = 'storage/' . $request->pdffile->store('websiteadmin');
        }

        // Handle the second image upload
        $second_image = null;
        if ($request->hasFile('second_image')) {
            $image = $request->file('second_image');
            if ($image->isValid()) {
                $targetDirectory = 'websiteadmin';
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/' . $targetDirectory), $fileName);
                $second_image = 'storage/' . $targetDirectory . '/' . $fileName;
            }
        }

        // Create a new WebsiteCourse instance and fill it with data
        $course = new WebsiteCourse();
        $course->title = $request->title;
        $course->program = $request->program;
        $course->lecture = $request->lecture;
        $course->duration = $request->duration;
        $course->session = $request->session;
        $course->feature = $request->feature;
        $course->description = $request->description;
        $course->type = $request->type;
        $course->pdffile = $pdfpath;
        $course->second_image = $second_image;
        $course->course_categoryy = $request->category; // Ensure this matches your form
        $course->seo_title = $request->seo_title;
        $course->seo_discription = $request->seo_discription;
        $course->alt_1 = $request->alt_1;
        $course->classtype = $request->classtype;
        $course->key_highlights = $request->key_highlights;
        $course->achievements = $request->achievements;
        $course->prerequisite = $request->prerequisite;


        // Save the course first to get its ID
        $course->save();

        // Save weekly titles and descriptions
        // foreach ($request->weeklytitle as $index => $title) {
        //     $week = new CourseWeek(); // Assuming you have a CourseWeek model
        //     $week->course_id = $course->id; // Associate with the course
        //     $week->weeklytitle = $title; // Use $title from the current iteration
        //     $week->weeklydescription = $request->weeklydescription[$index]; // Get corresponding description
        //     $week->save();
        // }

        return redirect()->route('websiteadmincourse')->with([
            'message' => 'Course Added Successfully!'
        ]);
    }

    

    public function edit($id)
    {
        $courseid = WebsiteCourse::with('courseWeeks')->find($id); // Fetch the course with its related weeks
    
        // Check if the course exists
        if (!$courseid) {
            // Handle the case where the course does not exist
            return redirect()->route('courses.index')->with('error', 'Course not found.');
        }
    
        $categories = CourseCategory::all(); // Fetch all categories
        $title = "Edit";
        $courseActive = 'active';
    
        // Extract weekly titles and descriptions
        $existingWeeklyTitles = $courseid->courseWeeks->pluck('weeklytitle')->toArray();
        $existingWeeklyDescriptions = $courseid->courseWeeks->pluck('weeklydescription')->toArray();
    
        return view('WebsiteAdmin.course.edit', compact('title', 'courseActive', 'courseid', 'categories', 'existingWeeklyTitles', 'existingWeeklyDescriptions'));
    }
    
    

    // public function update(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         // 'pdffile' => 'mimes:pdf|max:10000',
    //         // 'first_image' => 'dimensions:max_width=180,max_height=180',
    //         // 'second_image' => 'dimensions:max_width=400,max_height=400',
    //         // 'third_image' => 'dimensions:max_width=1300,max_height=628',

    //     ]);

    //     if ($validator->fails()) {
    //         return Redirect::back()->withErrors($validator)->with([
    //             'message' => 'Something went wrong!'
    //         ]);
    //     } else {
    //         if ($request->hasFile('pdffile') == !null) {
    //             $pdfpath = asset('storage/' . $request->pdffile->store('websiteadmin'));
    //         }
    //         if ($request->hasFile('second_image') == !null) {
    //             $second_image = asset('storage/' . $request->second_image->store('websiteadmin'));
    //         }


    //         $corse = WebsiteCourse::find($request->coursenewid);
    //         $corse->title = $request->title;
    //         $corse->program = $request->program;
    //         $corse->lecture = $request->lecture;
    //         $corse->duration = $request->duration;
    //         $corse->session = $request->session;
    //         $corse->feature = $request->feature;
    //         $corse->description = $request->description;
    //         $corse->type = $request->type;
    //         if ($request->seo_title != null && $request->seo_title != " ") {
    //             $corse->seo_title = $request->seo_title;

    //         } else {
    //             $corse->seo_title = "";

    //         }
    //         if ($request->seo_discription != null && $request->seo_discription != "") {
    //             $corse->seo_discription = $request->seo_discription;

    //         } else {
    //             $corse->seo_discription = "";

    //         }

    //         if ($request->alt_1 != null && $request->alt_1 != "") {
    //             $corse->alt_1 = $request->alt_1;

    //         } else {
    //             $corse->alt_1 = "";

    //         }
    //         if (isset($pdfpath)) {
    //             $corse->pdffile = $pdfpath;
    //         }
    //         if (isset($second_image)) {
    //             $corse->second_image = $second_image;
    //         }

    //         $corse->save();
    //     }
    //     return redirect()->route('websiteadmincourse')->with([
    //         'message' => 'Course Updated Successfully!'
    //     ]);

    // }

    public function destroy($id)
    {
        $corse = WebsiteCourse::find($id)->delete();
        return redirect()->route('websiteadmincourse')->with([
            'message' => 'Course Deleted Successfully!'
        ]);
    }
    public function update(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'pdffile' => 'nullable|file|max:10240',
            'description' => 'required',
            'type' => 'required',
            'title' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'lecture' => 'required|integer|min:1',
            'duration' => 'required|string|max:255',
            'session' => 'required|string|max:255',
            'feature' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_discription' => 'nullable|string|max:255',
            'alt_1' => 'nullable|string|max:255',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prerequisite' => 'nullable|string|max:255',
            // 'weeklytitle.*' => 'required|string',
            // 'weeklydescription.*' => 'required|string',
        ]);
       // dd($validator->errors()->all());

        if ($validator->fails()) {
            \Log::error('Validation errors: ', $validator->errors()->all());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        
        $course = WebsiteCourse::find($request->coursenewid);
        if (!$course) {
            \Log::error('Course not found for ID: ' . $request->coursenewid);
            return redirect()->route('websiteadmincourse')->with(['message' => 'Course not found!']);
        }

        // Handle PDF file upload
        $pdfpath = $course->pdffile;
        if ($request->hasFile('pdffile')) {
            $pdfpath = 'storage/' . $request->pdffile->store('websiteadmin');
        }

        // Handle second image upload
        $second_image = $course->second_image;
        if ($request->hasFile('second_image')) {
            $image = $request->file('second_image');
            if ($image->isValid()) {
                $targetDirectory = 'websiteadmin';
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/' . $targetDirectory), $fileName);
                $second_image = 'storage/' . $targetDirectory . '/' . $fileName;
            }
        }
       
      
        // Update course details
        $course->title = $request->title;
        $course->program = $request->program;
        $course->lecture = $request->lecture;
        $course->duration = $request->duration;
        $course->session = $request->session;
        $course->feature = $request->feature;
        $course->description = $request->description;
        $course->type = $request->type;
        $course->pdffile = $pdfpath;
        $course->second_image = $second_image;
        $course->seo_title = $request->seo_title ?? '';
        $course->seo_discription = $request->seo_discription ?? '';
        $course->alt_1 = $request->alt_1 ?? '';
        $course->course_categoryy = $request->category;
        $course->classtype = $request->classtype;
        $course->key_highlights = $request->key_highlights ?? '';
        $course->achievements = $request->achievements ?? '';
        $course->prerequisite = $request->prerequisite ?? '';

        // dd($request->all());
        $course->save();
        // Clear existing weeks and create new ones
         CourseWeek::where('course_id', $course->id)->delete();
        foreach ($request->weeklytitle as $index => $title) {
            $week = new CourseWeek();
            $week->course_id = $course->id;
            $week->weeklytitle = $title;
            $week->weeklydescription = $request->weeklydescription[$index];
            $week->save();
        }

        return redirect()->route('websiteadmincourse')->with(['message' => 'Course Updated Successfully!']);
    }

}