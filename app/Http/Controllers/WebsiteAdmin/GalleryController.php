<?php

namespace App\Http\Controllers\WebsiteAdmin;

use App\Models\Campus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallerytag;
use App\Models\WebsiteAdmin\Gallery;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index()
    {
        $title = "Gallery";
        $gallery = 'active';
        $galler = Gallery::with('campus','tags')->get();
        // $tags = Gallerytag::all();
        return view('WebsiteAdmin.Gallery.index', compact('title', 'gallery', 'galler'));
    }

    public function create()
    {

        $title = "Gallery";
        $gallery = 'active';
        $campuses = Campus::all();
        $tags = Gallerytag::all();
        return view('WebsiteAdmin.Gallery.create', compact('title', 'gallery', 'campuses', 'tags'));
    }

    public function store(Request $request)
    {




        // $validate = Validator::make($request->all(), [
        //     'campus_id'=>'required',
        //     'title' => 'required',
        //     'catagory'=>'required',
        //     'description'=>'required',

        // ]);
        // if($validate->fails()){
        //     return redirect()->back()->with([
        //         'message' => 'Something went wrong!!'
        //         ])->withErrors($validate)->withInput();
        //     }
        //     // return $request;

        $gallery = new Gallery();
        $allImages = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/gallery'), $imageName);
                $relativePath = 'gallery/' . $imageName;
                $allImages[] = $relativePath;
            }
        }

        // Convert the array of paths to a string separated by ||
        $imageString = implode('||', $allImages);
        $gallery->images = $imageString;
        $gallery->title = $request->title;
        $gallery->alt_1=$request->alt_1;
        $gallery->catagory =$request->tags;
        $gallery->save();

        return redirect()->route('website.gallery')->with([
            'message' => 'Images submitted successfully!'
        ]);
    }

    public function edit($id)
    {
        $galleryid = Gallery::find($id);
        $title = "Edit";
        $gallery = 'active';
        $tag=Gallerytag::find($galleryid->category);
        $tags=Gallerytag::all();
        return view('WebsiteAdmin.Gallery.edit', compact('title', 'gallery', 'galleryid','tag','tags'));
    }


    public function update(Request $request)
    {
        $gallery =  Gallery::find($request->id);
        $allImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/gallery'), $imageName);
                $relativePath = 'gallery/' . $imageName;
                $allImages[] = $relativePath;
            }
        }
        if($request->has('images')){

            $imageString = implode('||', $allImages);
            $gallery->images = $imageString;
        }
        // $gallery->campus_id = $request->campus_id;
        $gallery->title = $request->title;
        $gallery->alt_1=$request->alt_1;
        $gallery->catagory =$request->tags;
        $gallery->save();
        return redirect()->route('website.gallery')->with([
            'message' => 'Gallary Images Update successfully!'
        ]);
    }

    public function destory($id)
    {
        $gallery =  Gallery::find($id)->delete();
        return redirect()->route('website.gallery')->with([
            'message' => 'Gallary Images Delete successfully!'
        ]);
    }
       public function open($id){
        $title="gallery images";
        $gallery="gallery images";
        $data = Gallery::where('id',$id)->get();
        
        return view('WebsiteAdmin.Gallery.showgallery', compact('title', 'gallery', 'data','id'));
    }
    // Controller method to delete an image
    public function deleteImage($id, $key)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            $images = explode('||', $gallery->images);
    
            if (array_key_exists($key, $images)) {
                // Remove the image from the array
                unset($images[$key]);
    
                // Update the gallery record with the new images
                $gallery->images = implode('||', $images);
                $gallery->save();
    
                return redirect()->back()->with('message', 'Image deleted successfully');
            } else {
                return redirect()->back()->with('message', 'Invalid image key');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
    
            return redirect()->back()->with('message', 'An error occurred while deleting the image');
        }
    }

public function addImage(Request $request, $id)
{
    try {
        $gallery = Gallery::findOrFail($id);

        // Validate the uploaded file and other form data
        $request->validate([
            
            // Add other validation rules if needed
        ]);

        // Access the gallery_id from the request
        // $galleryId = $request->input('gallery_id');

        // Get the uploaded file
        $imageFile = $request->file('image');

        // Generate a unique filename for the image
        $imageName = time() . '_' . $imageFile->getClientOriginalName();

        // Move the file to the public/galleries directory
        $imagePath = $imageFile->move(public_path('storage/gallery'), $imageName);;

        // Update the gallery model with the new image path
        $gallery->images .= '||' . 'gallery/' . $imageName;
        $gallery->save();

        return redirect()->back()->with('message', 'Image added successfully');
    } catch (\Exception $e) {
        Log::error('Error adding image: ' . $e->getMessage());

        return redirect()->back()->with('message', 'An error occurred while adding the image');
    }
}

}
