<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Image;

class PostController extends Controller
{

    protected $validate = array(
        'title'          => 'required|max:255',
        'slug'           => 'required|max:255|min:5|alpha_dash|unique:posts,slug',
        'category_id'    => 'required|integer',
        'body'           => 'required',
        'featured_image' => 'sometimes|image'
    );

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
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::all();
        $data['tags'] = Tag::all()->pluck('name', 'id');
        return view('posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, $this->validate);

        $post = new Post();

        $post->title        = $request->title;
        $post->slug         = $request->slug;
        $post->category_id  = $request->category_id;
        $post->body         = $request->body;


        //Save our Image
        if($request->hasFile('featured_image')){
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $post->image = $filename;
        }


        $post->save();

        $post->tags()->sync($request->tags);


        Session::flash('success', 'The blog post was successfully saved!');

        return redirect()->route('posts.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['post'] = Post::find($id);
        $data['categories'] = Category::all()->pluck('name', 'id');
        $data['tags'] = Tag::all()->pluck('name', 'id');

        return view('posts.edit', $data);
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
        $post = Post::find($id);

        if($request->slug == $post->slug){
            $this->validate($request, array(
                'title' => 'required|max:255',
                'body'  => 'required'
            ));
        }else{
            $this->validate($request, $this->validate);
        }

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->category_id;
        $post->body = $request->input('body');


        //Save our Image
        if($request->hasFile('featured_image')){
            $oldFilename = $post->image;

            unlink(public_path('images/' . $oldFilename));

            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $post->image = $filename;
        }

        $post->save();

        if(empty ($request->tags)){
            $request->tags = [];
        }

        $post->tags()->sync($request->tags);

        Session::flash('success', 'This post was successfully saved.');

        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->tags()->detach();

        $post->delete();

        Session::flash('success', 'This post was successfully deleted.');

        return redirect()->route('posts.index');
    }
}
