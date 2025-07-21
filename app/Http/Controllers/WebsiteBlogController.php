<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTags;

class WebsiteBlogController extends Controller
{
    public function index()
    {
        $title="Blogs";
        
        $blog = Blog::orderBy('created_at', 'desc')->get();
        return view('WebsiteAdmin.blog.index',compact('blog','title'));
    }
    public function uploadimage(Request $req){
        if($req->hasFile('upload')){
            $originName=$req->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('upload')->getClientOriginalExtension();
            $fileName=$fileName.'_'.time().'.'.$extension;
            $req->file('upload')->move(public_path("blog_media"),$fileName);
            $url=asset('blog_media/'.$fileName);
            return response()->json(['fileName'=>$fileName,'uploaded'=>1,'url'=>$url]);
        }
    }
    public function create()
    {
        $title = "Create";
        $categorys = BlogCategory::all();

        
        return view('WebsiteAdmin.blog.create',compact('title','categorys'));

    }
    public function store(Request $request)
    {
      

        $validate = Validator::make($request->all(),[

            'title'=> 'required',
            'image'=> 'required',
            'description'=> 'required',
            'category'=>'required',
            'publishdat'=>'required'

        ]);
        if($validate->fails()){
                return redirect()->back()->with([
                    'message' => 'Something went wrong!!'
                ])->withErrors($validate)->withInput();
        }
        $blog = new Blog();
    

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Define the target directory
            $targetDirectory = 'blog';

            // Generate a random and unique filename
            $fileName = Str::random(20) . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to the specified directory
            $image->move(public_path('storage/' . $targetDirectory), $fileName);

            // Update the model with the file path (without the domain name)
            $blog->fimage = 'storage/' . $targetDirectory . '/' . $fileName;

        }
        $blog->publish_date=$request->publishdat;
        $blog->title = $request->title;
        $blog->catid=$request->category;
        $description = $request->description;

        // Using htmlspecialchars to escape special characters
        $escapedDescription = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        
        $blog->discription = $escapedDescription;
        $blog->seo_title=$request->seo_title;
        $blog->seo_discription=$request->alt_1;
        $blog->alt_1=$request->alt_1;
        // $tags->tags=$request->tags;
        $tagName = $request->tags;

// Attach the tag to the blog
        $tag = BlogTags::firstOrCreate(['tags' => $tagName]);

        // Update the blog record with the tag ID
        $blog->tagid = $tag->id;
        $blog->save();
    
        // $tags->blog_id=$request->
        return redirect()->route('website.blog')->with([
            'message' => 'News Added Successfully!'
        ]);


    }


   public function edit($id)
    {
        $title = "Edit";
     
        $annouid = Blog::find($id);
        $categorys=BlogCategory::all();
        $tags=BlogTags::find($annouid->tagid);
        $selectedCategoryId = $annouid->catid;
        return view('WebsiteAdmin.blog.edit',compact('annouid','title','selectedCategoryId','categorys','tags'));


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
        $blog = Blog::find($id);
        $tags=BlogTags::find($blog->tagid);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Define the target directory and file name
            $targetDirectory = 'blog';
            $fileName = time() . '_' . $image->getClientOriginalName();
        
            // Move the uploaded file to the specified directory
            $image->move(public_path('storage/' . $targetDirectory), $fileName);
        
            // Update the model with the file path
            $blog->fimage = asset('storage/' . $targetDirectory . '/' . $fileName);
        }
        $blog->title = $request->title;
        $blog->publish_date = $request->publishdata;
        $blog->catid=$request->category;
        $escapedHtml = htmlspecialchars($request->description, ENT_QUOTES, 'UTF-8');
        $blog->discription =$escapedHtml;
        $blog->seo_title=$request->seo_title;
        $blog->seo_discription=$request->alt_1;
        $blog->alt_1=$request->alt_1;
        $tags->tags=$request->tags;
        $tags->save();
        $blog->save();
        return redirect()->route('website.blog')->with([
            'message' => 'Blog Update Successfully!'
        ]);


    }

    public function destory($id)
    {
        $annouid = Blog::find($id)->delete();
        return redirect()->route('website.blog')->with([
            'message' => 'News Delete Successfully!'
        ]);



    }
    public function index_cat(){
        $title="Category";
        $category=BlogCategory::all();
        return view('WebsiteAdmin.blog.blog-category',compact('title','category'));
    }
    public function categoryadd(){
        $title="Category";
        return view('WebsiteAdmin.blog.category-create',compact('title'));
    }
    public function create_category(Request $req){
        $category=new BlogCategory;
        $category->name=$req->title;
        $category->save();
        return redirect()->route('category.list')->with([
            'message' => 'Category Added Successfully!'
        ]);

    }
    public function edit_cat($id){
        $title = "Edit";
        
        $category = BlogCategory::find($id);
        return view('WebsiteAdmin.blog.category-edit',compact('category','title'));
    }
    public function update_cat(Request $req){
        $id=$req->updateid;
        $category = BlogCategory::find($id);
        $category->name=$req->title;
        $category->save();
        return redirect()->route('category.list')->with([
            'message' => 'Category Updated Successfully!'
            ]);

    }
    public function destory_cat($id){
        $category = BlogCategory::find($id)->delete();
        return redirect()->route('category.list')->with([
            'message' => 'Category Deleted Successfully!'
            ]);


    }
}
