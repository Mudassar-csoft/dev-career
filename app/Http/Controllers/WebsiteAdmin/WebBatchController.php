<?php

namespace App\Http\Controllers\WebsiteAdmin;

use App\Models\Campus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\WebBatch;
use App\Models\WebsiteAdmin\WebsiteCourse;

class WebBatchController extends Controller
{
    public function index()
    {
        $title = "Batches";
        $batch = 'active';
        $webbatches = WebBatch::with('webcourse', 'campus')->get();
        return view('WebsiteAdmin.Batch.index',compact('title','batch', 'webbatches'));
    }

    public function addWebBatch()
    {
        $title = "Add Batch";
        $batch = 'active';
        $campuses = Campus::all();
        $courses = WebsiteCourse::all();

        return view('WebsiteAdmin.Batch.addbatch',compact('title','batch', 'campuses', 'courses'));
    }

    public function storeWebBatch(Request $req)
    {
        $batch = new WebBatch();
        $batch->status = $req->status;
        $batch->website_course_id = $req->website_course_id;
        $batch->start_date = $req->start_date;
        $batch->end_date = $req->end_date;
        $batch->session = $req->session;
        $batch->start_time = $req->start_time;
        $batch->end_time = $req->end_time;
        $batch->campus_id = $req->campus_id;
        $batch->save();
        return redirect()->route('webBatch')->with([
            'message' => 'Batch created successfully!'
        ]);
    }

    public function editWebBatch($id)
    {
        $title = "Edit Batch";
        $batch = 'active';
        $webbatch = WebBatch::find($id);
        $campuses = Campus::all();
        $courses = WebsiteCourse::all();

        return view('WebsiteAdmin.Batch.editbatch',compact('title','batch', 'campuses', 'courses', 'webbatch'));
    }

    public function updateWebBatch(Request $req)
    {
        $batch = WebBatch::find($req->batch_id);
        $batch->status = $req->status;
        $batch->website_course_id = $req->website_course_id;
        $batch->start_date = $req->start_date;
        $batch->end_date = $req->end_date;
        $batch->session = $req->session;
        $batch->start_time = $req->start_time;
        $batch->end_time = $req->end_time;
        $batch->campus_id = $req->campus_id;
        $batch->save();
        return redirect()->route('webBatch')->with([
            'message' => 'Batch updated successfully!'
        ]);
    }

    public function deleteWebBatch($id)
    {
        $batch = WebBatch::find($id)->delete();
        return redirect()->route('webBatch')->with([
            'message' => 'Batch deleted successfully!'
        ]);
    }

}