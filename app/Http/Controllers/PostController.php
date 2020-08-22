<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\User;
use Auth;
class PostController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }




   public function all_post(){
       $posts = Post::with('user', 'category')->orderBy('id','desc')->get();
       return response()->json([
           'posts' => $posts
       ], 200);
   }


   public function uploadImage( Request $request){
        $this->validate($request,[
            'file' => 'image | mimes:jpg,jpeg,png,gif'
        ]);
        $file = $request->file('file');
        $name = time().'.'.$request->file->getClientOriginalExtension();
        $upload_path = public_path('/assets/images/posts');
        $file->move($upload_path,$name);
        return $name;
   }


   public function deleteImage(Request $request){
    $filename = $request->image;
    $path = public_path('/assets/images/posts/').$filename;
    if(file_exists($path)){
        @unlink($path);
    }
    return 'Removed';
   }




   public function addPost(Request $request){
       $this->validate($request,[
           'title' => 'required',
           'description' => 'required',
           'photo' => 'required'
       ]);
       
       Post::create([
           'title' => $request->title,
           'description' => $request->description,
           'photo' => $request->photo,
           'category_id' => $request->categoryId,
           'user_id' =>Auth::user()->id
       ]);
       Category::where('id', $request->categoryId )->increment('count', 1);
       return [
        'message' => 'Post added'
       ];

   }


   public function deletePost($id){
       $post = Post::find($id);
       $filename = $post->photo;
       $path = public_path('/assets/images/posts/').$filename;
       if(file_exists($path)){
           @unlink($path);
       }
       Category::where('id', $post->category_id )->decrement('count', 1);
       $post->delete();
       return ['message' => 'Post Deleted'];
   }



   public function updatePost(Request $request){
      $post = Post::find($request->id);
      $filename = $post->photo;
      if($request->photo != $filename){
        $path=public_path('/assets/images/posts/').$filename;
        if(file_exists($path)){
            @unlink($path);
        }
      }
      if($post->category_id !== $request->category_id){
          Category::where('id', $request->category_id )->increment('count', 1);
          Category::where('id', $post->category_id )->decrement('count', 1);

      }
      $post->photo = $request->photo;
      $post->title = $request->title;
      $post->description = $request->description;
      $post->category_id= $request->category_id;
      $post->save();

      return ['message' => 'Post Updated'];
   }



//Get Post By User
//    public function userPost(){
//     $id = Auth::user()->id;
//     $user = User::find($id);
//     $allpost = $user->posts()->with('user' ,'category')->orderBy('id', 'desc')->get();
//     return response()->json([
//         'posts' => $allpost
//     ]);
//    }
}
