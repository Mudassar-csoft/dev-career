<?php

namespace App\Http\Controllers\WebsiteAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campus;
use App\Models\Gallerytag;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\Gallery;
use Illuminate\Support\Facades\Validator;
class GalleryTagsController extends Controller
{
   public function create(){
    $title = "Gallery";
    $gallery = 'active';
    $gallers=Gallerytag::all();
    // $galler = Gallery::with('campus')->get();
    return view('WebsiteAdmin.Gallery.createtags',compact('title','gallery','gallers'));
    
   }
   public function store(Request $req){
    $gallerTags=new Gallerytag();
    $gallerTags->title=$req->title;
    $gallerTags->save();
    if($gallerTags->save()){
        return redirect()->route('website.gallerytags')->with([
            'message' => 'Tags Edit Successfully'
        ]);}

        else{
         return redirect()->route('website.gallerytags')->with([
             'Error' => 'Sorry Try again'
         ]);
        
     }   
    
   } 
   public function edit($id){
    $galleryid=Gallerytag::find($id);
    // $gallerTags->title=$req->title;
    $title = "Edit";
    $gallery = 'active';
    return view('WebsiteAdmin.Gallery.edittags',compact('title','gallery','galleryid'));

   }
   public function  update(Request $req){
    $galleryTags=Gallerytag::find($req->id);
    $galleryTags->title=$req->title;
   $galleryTags->save();
   if( $galleryTags->save()){
    return redirect()->route('website.gallery')->with([
        'message' => 'Tags Edit Successfully'
    ]);
}

    else{
     return redirect()->route('website.gallery')->with([
         'Error' => 'Sorry Try again'
     ]);
}
   }
}