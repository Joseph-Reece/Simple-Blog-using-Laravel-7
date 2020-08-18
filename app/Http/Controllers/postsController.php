<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use Illuminate\Support\Facades\Storage;

class postsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except'=> ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Posts::orderby('updated_at' , 'desc')->paginate(5);
        return view('posts.index')-> with('posts' , $post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' =>'image|nullable|max:6999'
        ]);
        // dd($request->file('cover_image'));

        // handle file upload

        if ($request->hasFile('cover_image')) {
            # get file name with extensions
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            #get the file name
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            #get the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            #get the filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;

            #upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }else{
            $filenameToStore = 'no_image.jgp';
        }

        $post = new posts();
        $post ->title = $request->input('title');
        $post ->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $filenameToStore; //after this create a symbiotic link between storage folder php artisan storage:link
        $post->save();

        return redirect('/posts')->with('success', 'Post succesfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Posts::find($id);
        return view('posts.show');
        // $post = Posts::find($id);
        // return view('posts.show')->with('posts' , $post);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Posts::find($id);

        if (auth()->user()->id !== $post->user_id) {
            # code...
            return redirect('/posts')->with('error', 'Unauthorized Page!!!');
        }

        return view('posts.edit')->with('post', $post);
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
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($request->hasFile('cover_image')) {
            # code...
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }

        $post = Posts::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            # code...
            $post->cover_image = $filenameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post succesfully Updated!!!');

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
        $post = Posts::find($id);

        if (auth()->user()->id !== $post->user_id) {
            # code...
            return redirect('/posts')->with('error', 'Unauthorized Page!!!');
        }

        if ($post->cover_image !='no_image.jpg') {
            # code...
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();

        return redirect('/posts')->with('success', 'Post succesfully Deleted!!!');

    }
}
