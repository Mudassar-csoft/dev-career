<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Batch;
use App\Models\Campus;
use App\Models\Country;
use App\Models\WebLead;
use App\Models\Admission;
use App\Models\OldAdmission;
use Illuminate\Support\Facades\Log;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use App\Models\CertificateRequest;
use App\Models\WebsiteAdmin\Event;
use App\Models\WebsiteAdmin\Gallery;
use App\Models\WebsiteAdmin\WebBatch;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Models\WebsiteAdmin\Announcement;
use App\Models\WebsiteAdmin\Verification;
use Illuminate\Support\Facades\Validator;
use App\Models\WebsiteAdmin\WebsiteCourse;
use App\Models\WebsiteAdmin\CoworkingSpace;
use App\Models\Gallerytag;
// use App\Models\Gallery;
use App\Models\BlogCategory;
use App\Models\CourseCategory;
use App\Models\CourseWeek;
use App\Http\Controllers\JobAndCareerController;
use App\Http\Controllers\PostJobController;
use App\Models\JobAndCareer;



class WebsiteController extends Controller
{
    public function index()
    {
        // $title = "Computer Course";
        $date = date('Y-m-d');
        $feature_courses = WebsiteCourse::where('feature', 'Feature')->get();
        $feature_coursess = WebsiteCourse::where('feature', 'Feature')->orderBy('id', 'DESC')->get();
        $normal_courses = WebsiteCourse::orderBy('id', 'DESC')->get();
        $announcements = Announcement::all();
        $events = Event::with('campus')->get();
        //        dd($events);
        //        gallerytag
        $gallery = Gallery::all();
        $galleryTags = Gallerytag::with('galleries')->get();

        foreach ($galleryTags as $tag) {
            $perGalleryImages = max(8 / max($tag->galleries->count(), 1), 1);
            $imageArray = [];

            foreach ($tag->galleries as $gallery) {
                $galleryImages = explode('||', $gallery->images);

                for ($index = 0; $index < $perGalleryImages && $index < count($galleryImages); $index++) {
                    $setup = [
                        'id' => $gallery->id,
                        'title' => $gallery->title,
                        'image' => $galleryImages[$index],
                    ];
                    $imageArray[] = $setup;
                }
            }

            $tag->gallery_images = $imageArray;
        }

        // dd($galleryTags);
        $response = Http::withHeaders([
            'Accept' => 'application/json', // or another content type
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json(); // Decode JSON response to an array or object
        } else {
            $campuses = []; // Fallback if the API call fails
        }
        $batches = WebBatch::where('status', 'Publish')->with('campus', 'webcourse')->orderBy('start_date', 'ASC')->get();
        $blog = Blog::with('blogcate')->orderBy('created_at', 'desc')->get();
        $countries = Country::all();
        return view('Web.home', compact('gallery', 'galleryTags', 'feature_courses', 'feature_coursess', 'blog', 'normal_courses', 'announcements', 'events', 'batches', 'campuses', 'countries'));
    }

    public function reqVerification(Request $req)
    {

        $validate = Validator::make($req->all(), [

            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'company' => 'required|regex:/^[\pL\s\-]+$/u',
            'number' => 'required|numeric',
            'email' => 'required|email',
            'code' => 'required',
            // 'g-recaptcha-response' => function ($attribute, $value, $fail) {

            //     $secretkey = '6LfbyWEiAAAAAGfB9gPGXJyhy2yv_RimJ12maubc';
            //     $response = $value;
            //     $userid = $_SERVER['REMOTE_ADDR'];
            //     $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$userid";
            //     $response = \file_get_contents($url);
            //     $response = json_decode($response);
            //     if (!$response->success) {
            //         Session::flash('error', 'Please Check reCaptcha');
            //         // Session::flash('alert-class','alert-danger');
            //         $fail($attribute . 'google reCaptcha failed');
            //     }
            // },
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withInput($req->input())->withErrors($validate)->with([
                'error' => 'Something went wrong!!',
            ]);
        } else {
            $code = $req->input('code');
            $admission = Admission::where('roll_number', $code)->where('status', 'Delivered')->get();
            if (count($admission) > 0) {
                $varifi = new Verification();
                $varifi->name = $req->input('name');
                $varifi->company = $req->input('company');
                $varifi->number = $req->input('number');
                $varifi->email = $req->input('email');
                $varifi->code = $req->input('code');
                $varifi->status = "Verified";
                $varifi->save();
                return view('Web.successfull_verification', compact('admission'));
            }

            $old_admission = OldAdmission::where('roll_number', $code)->where('status', 'Certified')->get();
            if (count($old_admission) > 0) {
                $varifi = new Verification();
                $varifi->name = $req->input('name');
                $varifi->company = $req->input('company');
                $varifi->number = $req->input('number');
                $varifi->email = $req->input('email');
                $varifi->code = $req->input('code');
                $varifi->status = "Verified";
                $varifi->save();
                return view('Web.successfull_verification', compact('old_admission'));
            } else {
                $varifi = new Verification();
                $varifi->name = $req->input('name');
                $varifi->company = $req->input('company');
                $varifi->number = $req->input('number');
                $varifi->email = $req->input('email');
                $varifi->code = $req->input('code');
                $varifi->status = "Unverified";
                $varifi->save();
                $unverified = "Unverified";
                return view('Web.successfull_verification', compact('unverified'));
            }
        }
    }

    public function allNews()
    {
        $title = "All News";
        $news = Announcement::OrderBy('id', 'desc')->get();
        return view('Web.allnews', compact('title', 'news'));
    }
    public function singlnews($id)
    {
        $title = "All News";
        $news = Announcement::OrderBy('id', 'desc')->get();
        $announcement = Announcement::where('id', $id)->first();
        return view('Web.single_news', compact('title', 'news', 'announcement'));
    }

    public function allBatches()
    {
        $title = "All Batches";
        $date = date('Y-m-d');
        $batches = WebBatch::where('status', 'Publish')->with('campus', 'webcourse')->orderBy('start_date', 'ASC')->get();
        $announcements = Announcement::all();

        return view('Web.allbatches', compact('title', 'announcements', 'batches'));
    }

    public function showCourse($id, $title)
    {
        // Fetch the course along with its webbatch
        $course = WebsiteCourse::with('webbatch')->find($id);

        // Retrieve the weeks associated with the course
        $courseweek = $course ? $course->courseWeeks : collect(); // Assuming a relationship exists

        // Retrieve the category ID from the current course
        $categoryId = (is_object($course) && isset($course->course_categoryy)) ? $course->course_categoryy : null;

        // Fetch normal courses that have the same category ID as the current course
        $normal_courses_query = WebsiteCourse::where('course_categoryy', $categoryId)
            ->where('id', '!=', $id);

        // Paginate the normal courses
        $normal_courses = $normal_courses_query->paginate(3);

        // Check if the paginated result has fewer than 3 courses
        if ($normal_courses->total() < 5) {
            $additional_courses_count = 5 - $normal_courses->total();
            $additional_courses = WebsiteCourse::where('id', '!=', $id)
                ->inRandomOrder()
                ->limit($additional_courses_count)
                ->get();

            $normal_courses->setCollection($normal_courses->getCollection()->merge($additional_courses));
        }

        // Fetch other data
        $announcements = Announcement::paginate(3);
        $events = Event::with('campus')->get();
        $response = Http::withHeaders([
            'Accept' => 'application/json', // or another content type
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json(); // Decode JSON response to an array or object
        } else {
            $campuses = []; // Fallback if the API call fails
        }
        // Return the view with the required data
        return view('Web.showcoursedetails', compact('title', 'course', 'normal_courses', 'courseweek', 'announcements', 'events', 'campuses'));
    }

    public function aboutUs()
    {
        $title = "About Us";
        $announcements = Announcement::all();
        return view('Web.aboutus', compact('title', 'announcements'));
    }

    public function shortCourses()
    {
        $title = "Short Courses";
        $feature_courses = WebsiteCourse::where('feature', 'Feature')->get();
        $announcements = Announcement::all();
        $response = Http::withHeaders([
            'Accept' => 'application/json', // or another content type
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json(); // Decode JSON response to an array or object
        } else {
            $campuses = []; // Fallback if the API call fails
        }
        return view('Web.shortcourses', compact('title', 'feature_courses', 'announcements', 'campuses'));
    }

    public function courses()
    {
        $title = "Short Courses";
        $feature_courses = WebsiteCourse::where('feature', 'Feature')->get();
        $announcements = Announcement::all();
        $response = Http::withHeaders([
            'Accept' => 'application/json', // or another content type
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json(); // Decode JSON response to an array or object
        } else {
            $campuses = []; // Fallback if the API call fails
        }
        $category = CourseCategory::all();
        return view('Web.newshortCourses', compact('title', 'category', 'feature_courses', 'announcements', 'campuses'));
    }


    public function searchcourse(Request $request)
    {

        // Log::info('Search request received', $request->all());
        $query = WebsiteCourse::where('feature', 'Feature');

        if ($request->input('keyword') != '') {
            $query->where('title', 'LIKE', '%' . $request->input('keyword') . '%');
        }

        $courses = $query->get()->map(function ($course) {
            return [
                'id' => isset($course->id) ? $course->id : null,
                'title' => htmlspecialchars($course->title ?? ''),
                'description' => htmlspecialchars($course->description ?? ''),
                'second_image' => $course->second_image ?? '',
                'type' => $course->type ?? '',
                'course_categoryy' => $course->course_categoryy ?? '',
            ];
        });

        return response()->json([
            'courses' => $courses,
            'keyword' => $request->input('keyword')
        ]);
    }

    public function pearsonTesting()
    {
        $title = "Pearson Testing";
        return view('Web.pearsonpage', compact('title'));
    }

    public function psiExamCenter()
    {
        $title = "PSI Exam Center";
        return view('Web.psiexamcenter', compact('title'));
    }

    public function kryterionTestingCenter()
    {
        $title = "Kryterion Testing Center";
        return view('Web.kryteriontestingcenter', compact('title'));
    }

    // public function sharedWorkspace()
    // {
    //     $title = "Shared Workspace";
    //     return view('Web.sharedworkspace', compact('title'));
    // }
    public function Workspace()
    {
        $randomblog = Blog::inRandomOrder()->get();
        $title = "Shared Workspace";
        return view('Web.coworking_space', compact('title', 'randomblog'));
    }
    public function slip()
    {
        return view('Web.slip');
    }
    public function studyAbroad()
    {
        $title = "Study Abroad";
        return view('Web.studyabroad', compact('title'));
    }

    public function howToPay()
    {
        $title = "How to Pay";
        return view('Web.howtopay', compact('title'));
    }

    public function verification()
    {
        $title = "Verification";
        return view('Web.verification', compact('title'));
    }


    public function jobPlacement()
    {
        $title = "Job Placement";
        return view('Web.jobplacement', compact('title'));
    }

    public function careerjob()
    {
        $title = "Job Placement";

        // Dummy data for testing
        $jobplace = collect([
            (object)[
                'id' => 1,
                'title' => 'Web Developer',
                'description' => 'Looking for a skilled web developer with Laravel experience.',
                'location' => 'Lahore',
                'status' => 'approved',
                'job_type' => 'Part-Time',
                'company' => 'DesignPro Studio',
                'deadline' => '2025-08-15'
            ],
            (object)[
                'id' => 2,
                'title' => 'Graphic Designer',
                'description' => 'Expert in Adobe Illustrator and Photoshop.',
                'location' => 'Karachi',
                'status' => 'approved',
                'job_type' => 'Full-Time',
                'company' => 'TechSoft Ltd.',
                'deadline' => '2025-08-10'
            ]
        ]);

        return view('Web.sharedworkspace', compact('title', 'jobplace'));
    }
    public function postjob()
    {
        $title = "Post Job";
        return view('Web.job-post-form',  compact('title'));
    }


    public function ambassadorProgram()
    {
        $title = "Ambassador Program";
        $data['countries'] = Country::get(["name", "id"]);
        return view('Web.ambassadorprogram', $data, compact('title'));
    }

    public function contactUs()
    {
        $title = "Contact Us";

        // Dummy campuses data for testing
        $campuses = [
            [
                'name' => 'Career Institute - Madina Town Campus',
                'address' => 'Career Institute, P-49, Chenab Market, Susan Road, Block Z, Madina Town, Faisalabad, Punjab, Pakistan - 38000',
                'phone' => '0418542950 03007662050',
            ],
            [
                'name' => 'Career Institute - Jinnah Colony Campus',
                'address' => 'Career Institute, P-54, 3rd Floor, BC Tower, Jinnah Colony, Near GC University - Gate 6, Faisalabad, Punjab, Pakistan - 38000',
                'phone' => '0412640083 03002032970',
            ],
            [
                'name' => 'Career Institute - Millat Chowk Campus',
                'address' => 'Career Institute, P-165 B, 262 Millat Rd, Millat Chowk, Gulistan Colony, Faisalabad, Punjab, Pakistan - 38000',
                'phone' => '0418580027 03158580027',
            ],
            [
                'name' => 'Career Institute - Satiana Road Campus',
                'address' => 'Career Institute, P-703, Batala Colony, Main Satiana Road, Faisalabad, Punjab, Pakistan - 38000',
                'phone' => '0418580027 03158580027',
            ],
            [
                'name' => 'Career Institute - Samnabad Campus',
                'address' => 'Career Institute, P-649, Canal Link Road, Samnabad, Faisalabad, Punjab, Pakistan - 38000',
                'phone' => '0418580027 03158580027',
            ],
        ];

        return view('Web.contactus', compact('title', 'campuses'));
    }

    public function blogs(Request $request)
    {

        $id = $request->input('id');

        if ($id) {
            $category = BlogCategory::find($id);

            if ($category) {
                $blogs = Blog::where('catid', $id)->orderBy('created_at', 'desc')->get();
            } else {
                $blogs = Blog::with('blogcate')->orderBy('created_at', 'desc')->get();
            }
        } else {
            $blogs = Blog::with('blogcate')->orderBy('created_at', 'desc')->get();
        }
        $blogcategory = BlogCategory::all();
        return view('Web.new_blog', compact('blogs', 'blogcategory'));
    }

    public function blogdetails($id)
    {
        $blogdetail = Blog::with('blogTag')->find($id);
        // dd($blogdetail);
        $blogcategory = BlogCategory::all();
        $blogcatid = $blogdetail->input('catid');
        $randomblog = Blog::inRandomOrder()->get();
        $blogs = Blog::where('catid', $blogcatid)->orderBy('created_at', 'desc')->get();
        return view('Web.blog_details', compact('blogdetail', 'blogs', 'blogcategory', 'randomblog'));
    }


    public function blogcatdetail($id)
    {
        $id = decrypt($id);
        $blogcat = Blog::where('catid', $id)->get();
        //        dd($blogcat);
        return view('Web.blogcat_detail', compact('blogcat'));
    }

    public function brochuredata(Request $request)
    {

        $existingLead = WebLead::where('primary_contact', $request->input('primary_contact'))->first();


        if ($existingLead) {
            return response()->json(['success' => false, 'message' => "A lead with this email and phone number already exists. Please enter a unique email address and contact number"], 500);;
        }

        try {
            $data = WebLead::updateOrCreate(
                ['id' => $request->input('id')],
                [
                    'name' => $request->input('name'),
                    'course' => $request->input('course'),
                    'primary_contact' => $request->input('primary_contact'),
                    'email' => $request->input('email'),
                    'country_id' => $request->input('country_id'),
                    'state_id' => $request->input('state_id'),
                    'city' => $request->input('city'),
                    'remarks' => $request->input('remarks'),
                    'campus_id' => $request->campus_id ?? 9,
                    'type' => $request->type ?? 'Brochure Lead',
                ]
            );

            $response = Http::post('https://new-portal.csoft.live/api/web-leads', [
                'name' => $data->input('name'),
                'course' => $data->input('course'),
                'primary_contact' => $data->input('primary_contact'),
                'campus_id' => $data->input('campus_id'),
                'gender' => $data->gender ?? 'Male',
                'email' => $data->input('email'),
                //'country_id' => $data->country_id,
                //'state_id' => $data->state_id,
                'city' => 'Faisalabad',
                //'dob' =>$data->dob,
                'status' => $data->status ?? 'Pending',
                'type' => $data->input('type'),
                //'question_or_comment' => $data->question_or_comment,
                //'education' => $data->education,
                //'guardian_name' => $data->guardian_name,
                //'guardian_contact' => $data->guardian_contact,
                //'postal_address' => $data->postal_address,
                //'remarks' => $data->remarks,
            ]);

            if (!$response->successful()) {

                $data->delete();
                return response()->json(['success' => false, 'message' => "A lead with this email and phone number already exists. Please enter a unique email address and contact number"], 500);;
            }
            // Return success response
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            // Log the error
            //Log::error('Error saving WebLead: ' . $e->getMessage());

            // Return error response with exception message
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }





    public function events()
    {
        $title = "Events";
        $events = Event::with('campus')->get();
        $blog = Blog::inRandomOrder()->get();
        $courses = WebsiteCourse::where('feature', 'Feature')->paginate(4);
        return view('Web.events', compact('title', 'events', 'blog', 'courses'));
    }

    public function event_detail($id)
    {
        $title = "Events";
        $event_details = Event::find($id);
        $blogdetail = Blog::inRandomOrder()->get();
        $response = Http::withHeaders([
            'Accept' => 'application/json', // or another content type
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json(); // Decode JSON response to an array or object
        } else {
            $campuses = []; // Fallback if the API call fails
        }
        $courses = WebsiteCourse::inRandomOrder()->where('feature', 'Feature')->paginate(4);
        return view('Web.event_detail', compact('title', 'campuses', 'event_details', 'blogdetail', 'courses'));
    }

    public function singleevents($id)
    {
        $title = "Events";
        $event = Event::with('campus')->find($id);
        $Announcement = Announcement::all();
        return view('Web.single_event', compact('title', 'event', 'Announcement'));
    }


    public function leads(Request $request)
    {
        try {

            $existingLead = WebLead::where('primary_contact', $request->input('primary_contact'))->first();


            if ($existingLead) {
                return redirect('/')->with('error', 'A lead with this email and phone number already exists. Please enter a unique email address and contact number');
            }


            $lead = new WebLead();

            // Handling different types of leads
            switch ($request->input('type')) {
                case "Lead":
                    $lead->name = $request->input('name');
                    $lead->course = $request->input('course');
                    $lead->primary_contact = $request->input('primary_contact');
                    $lead->campus_id = $request->input('campus_id');
                    $lead->gender = $request->input('gender');
                    $lead->email = $request->input('email');
                    $lead->country_id = $request->input('country_id');
                    $lead->state_id = $request->input('state_id');
                    $lead->city = $request->input('city');
                    $lead->dob = $request->input('dob');
                    $lead->status = $request->input('status');
                    $lead->type = $request->input('type');
                    $lead->question_or_comment = $request->input('question_or_comment');
                    break;

                case "Admission":
                    $lead->course = $request->input('course');
                    $lead->name = $request->input('name');
                    $lead->primary_contact = $request->input('primary_contact');
                    $lead->gender = $request->input('gender');
                    $lead->email = $request->input('email');
                    $lead->education = $request->input('education');
                    $lead->guardian_name = $request->input('guardian_name');
                    $lead->guardian_contact = $request->input('guardian_contact');
                    $lead->campus_id = $request->input('campus_id');
                    $lead->country_id = $request->input('country_id');
                    $lead->state_id = $request->input('state_id');
                    $lead->city = $request->city;
                    $lead->dob = $request->dob;
                    $lead->postal_address = $request->postal_address;
                    $lead->status = $request->status;
                    $lead->type = $request->type;
                    $lead->remarks = $request->remarks;
                    break;

                case "Quick Lead":
                    $lead->name = $request->name;
                    $lead->course = $request->course;
                    $lead->primary_contact = $request->primary_contact;
                    $lead->email = $request->email;
                    $lead->country_id = $request->country;
                    $lead->city = $request->city;
                    $lead->status = $request->status;
                    $lead->type = $request->type;
                    $lead->campus_id = 9;
                    break;

                default:
                    $lead->name = $request->name;
                    $lead->course = $request->course;
                    $lead->primary_contact = $request->primary_contact;
                    $lead->email = $request->email ?? "Not Provided";
                    $lead->country_id = $request->country;
                    $lead->city = $request->city;
                    $lead->status = $request->status;
                    $lead->type = $request->type;
                    $lead->campus_id = 9;
                    break;
            }

            // Save the lead locally
            $lead->save();

            // Make API call to the other Laravel site
            $response = Http::post('https://new-portal.csoft.live/api/web-leads', [
                'name' => $request->input('name'),
                'course' => $request->input('course'),
                'primary_contact' => $request->input('primary_contact'),
                'campus_id' => $request->input('campus_id'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city' => $request->input('city'),
                'dob' => $request->input('dob') ? Carbon::parse($request->input('dob'))->format('Y-m-d') : null,
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'question_or_comment' => $request->input('question_or_comment'),
                'education' => $request->input('education'),
                'guardian_name' => $request->input('guardian_name'),
                'guardian_contact' => $request->input('guardian_contact'),
                'postal_address' => $request->input('postal_address'),
                'remarks' => $request->input('remarks'),
            ]);
            //dd($response);
            // Check if the API call was successful
            if ($response->successful()) {

                return redirect('/')->with('message', 'Submitted Successfully');
            } else {
                // Log the error and return a message indicating failure
                Log::error('Failed to sync with new-portal.csoft.live: ' . $response->body());
                return redirect('/')->with('error', $response->getMessage());
            }
        } catch (\Exception $ex) {
            // Log the error
            return redirect('/')->with('error', $ex->getMessage());
        }
    }


    public function leadeshow($id)
    {
        $title = 'Lead Profile';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $leadprofileid = WebLead::with('program', 'campus', 'country', 'state')->find($id);

        return view('Admin.Enquiry.webleadprofile', compact('leadprofileid', 'title', 'enquiry_open', 'enquiry'));
    }

    public function cnic(Request $request)
    {
        $cn = "https://new-portal.csoft.live/api/getCandidate/{$request->cnic}";
        //dd($cn);
        $data = Http::get($cn);
        $cnic = $data->json();
        //$cnic = Registration::select('registration_number', 'id','name')->where('cnic', $request->cnic)->first();
        //$cnic_count = Registration::where('cnic', $request->cnic)->count();
        //dd($cnic->json());
        $rolnum = 0;
        if ($cnic > 0) {
            $rolnum = $cnic;
            //$rolnum = Admission::where('registration_id', $cnic->id)->with('program')->get();
            //if (count($rolnum) > 0) {
            return response()->json(['cnic' => $request->cnic, 'rolnum' => $rolnum]);
            //return response()->json(['cnic' => $cnic, 'rolnum' => $rolnum]);
            //} else {
            //  $rolnum = 1;
            //return response()->json(['cnic' => $cnic, 'rolnum' => $rolnum]);

            //}
        }
        //else {
        //$rolnum = 0;
        //  return response()->json(['cnic' => $cnic, 'rolnum' => $rolnum]);
        //}

        return response()->json(['cnic' => $request->cnic, 'rolnum' => $rolnum]);
    }



    public function rollNumber(Request $request)
    {

        //$validate = FeeCollection::orderBy('id','DESC')->where('admission_id', $request->admissionId)->first();

        $url = "https://new-portal.csoft.live/api/getRollNumber/{$request->admissionId}";
        // if($validate->status == 'Clear')
        // {
        $data = Http::get($url);
        $admissionnewid = $data->json();

        //= Admission::with('campus')->where('id', $request->admissionId)->first();
        if ($admissionnewid) {
            return response(['rollNumber' => $admissionnewid]);
        } else {
            return response(['rollNumber' => Null]);
        }
    }




    // public function rollNumberstore(Request $request)
    // {

    //     $feecheck = FeeCollection::orderBy('id','DESC')->where('admission_id', $request->admission_id)->first();
    //       if($feecheck->status == 'Clear'){
    //         // dd($feecheck);   
    //           $admission = Admission::find($request->admission_id);
    //         if ($admission->status == 'Enrolled') {
    //             $admission->status = 'Requested';
    //             $admission->save();
    //             return redirect()->back()->with([
    //                 'message' => 'Certificate Request Successfully!',
    //             ]);
    //         }else if($admission->status == 'Delivered'){
    //              return redirect()->back()->with([
    //                 'message' => 'Verified Request Successfully!',
    //             ]);
    //         }
    //         else{
    //              return redirect()->back()->with([
    //                 'error' => 'Already Requested',
    //             ]);
    //         }
    //       }else{
    //             return redirect()->back()->with([
    //                 'error' => 'Dues Pending! Contact With Admission Coordinator ',
    //             ]);
    //       }



    // }
    public function rollNumberstore(Request $request)
    {
        // Check for the fee status
        $feecheck = FeeCollection::orderBy('id', 'DESC')
            ->where('admission_id', $request->admission_id)
            ->first();

        if ($feecheck->status == 'Clear') {
            $admission = Admission::find($request->admission_id);

            if ($admission->status == 'Enrolled') {
                $admission->status = 'Requested';
                $admission->save();

                // Make API call to notify about the status change
                $response = Http::post('https://new-portal.csoft.live/api/rollnumber-certificate', [
                    'admission_id' => $request->admission_id,
                    'status' => 'Requested',
                ]);

                if ($response->successful()) {
                    return redirect()->back()->with([
                        'message' => 'Certificate Request Successfully!',
                    ]);
                } else {
                    Log::error('Failed to notify status change: ' . $response->body());
                    return redirect()->back()->with([
                        'error' => 'Something went wrong while notifying the status change.',
                    ]);
                }
            } else if ($admission->status == 'Delivered') {
                return redirect()->back()->with([
                    'message' => 'Verified Request Successfully!',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'Already Requested',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Dues Pending! Contact With Admission Coordinator ',
            ]);
        }
    }

    public function verifyrollNumberstore(Request $request)
    {
        dd($request->all());
    }
    public function getCoursesByCategory(Request $request, $categoryId = null)
    {
        $search = $request->input('search');

        if (!is_null($categoryId)) {
            // Filter by category first
            $query = WebsiteCourse::where('course_categoryy', $categoryId);

            // Apply search within the filtered category
            if (!empty($search)) {
                $query->where('title', 'like', '%' . $search . '%');
            }

            $feature_courses = $query->get();
        } else {
            // If no category, search globally by title
            $feature_courses = !empty($search)
                ? WebsiteCourse::where('title', 'like', '%' . $search . '%')->get()
                : WebsiteCourse::all();
        }

        if ($feature_courses->isEmpty()) {
            return response()->json(['message' => 'No courses found'], 404);
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json();
        } else {
            $campuses = [];
        }
        $category = CourseCategory::all();

        //$coursesHtml = view('Web.newshortCourses', compact('feature_courses','category', 'campuses'))->render();
        return response()->json(['coursesHtml' => $feature_courses, 'cat' => $categoryId]);
    }



    public function certification()
    {

        return view('Web.request_certificate');
    }
    public function search_bar_course()
    {
        $feature_courses = WebsiteCourse::orderby('id', 'DESC')->paginate(40);
        $response = Http::withHeaders([
            'Accept' => 'application/json', // or another content type
        ])->get('https://new-portal.csoft.live/api/campuses');

        if ($response->successful()) {
            $campuses = $response->json(); // Decode JSON response to an array or object
        } else {
            $campuses = []; // Fallback if the API call fails
        }
        if (isset($_GET['query'])) {
            $search_bar_input = $_GET['query'];
            $feature_courses = WebsiteCourse::orderBy('id', 'DESC')
                ->where('title', 'LIKE', '%' . $search_bar_input . '%')
                ->paginate(4)
                ->withQueryString();
        } else {
            return view('Web.shortcourses', compact('feature_courses', 'campuses'));
        }

        return view('Web.shortcourses', compact('feature_courses', 'campuses'));
    }
    public function gallery()
    {
        // $gallery = Gallery::all();
        // // $gallerycat = Gallery::all();

        // // Extract image paths from the stored array
        // $images = [];
        // $gallerycat = [];
        // foreach ($gallery as $galleryItem) {
        //     $images[$galleryItem->id] = explode('||', $galleryItem->images);
        //     $gallerycat[$galleryItem->id]= $galleryItem->catagory;
        // }
        $gallery = Gallery::all();
        $galleryTags = Gallerytag::with('galleries')->get();

        foreach ($galleryTags as $tag) {
            $imageArray = [];

            foreach ($tag->galleries as $gallery) {
                $galleryImages = explode('||', $gallery->images);

                foreach ($galleryImages as $image) {
                    $setup = [
                        'id' => $gallery->id,
                        'title' => $gallery->title,
                        'image' => $image,
                    ];
                    $imageArray[] = $setup;
                }
            }

            $tag->gallery_images = $imageArray;
        }

        return view('Web.gallery', compact('galleryTags'));
    }
}
