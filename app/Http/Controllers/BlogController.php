<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
class BlogController extends Controller
{
    //
    public function blogPost(){
        // $posts = Post::with('user' ,'category')->orderBy('id','desc')->get();
        // return response()->json([
        //     'posts' => $posts
        // ],200);

        $posts =  Post::with(array('user'=>function($query){
            $query->select('id','name');
        },'category'))->get();
        return response()->json([
                'posts' => $posts
            ],200);
    }

    public function singlePost($id){
        $post = Post::with(array('user'=>function($query){
            $query->select('id','name');
        },'category'))->find($id);
        return response()->json([
            'post' => $post
        ], 200 );
    }

    //All Categories
    public function allCategories(){
        $categories = Category::select('id','category_name','count')->get();
        return response()->json([
            'categories' => $categories
        ],  200 );
    }


    //   LATEST POST

    public function latestPost(){
    $posts =  Post::select('id','description','title','photo')->orderBy('created_at', 'desc')->get();
    return response()->json([
        'posts' => $posts
    ], 200 );
    }



    //CATEGORY WISE
    public function categoryWisePost($id){
        $posts = Post::with(array('user' =>function($query){
            $query->select('id', 'name');
        },'category'))->where('category_id', '=', $id)->get();

        return $posts;
    }

    //SEARCHING

    public function searchPost(){
        $searchquery = \Request::query('query');
        $posts = Post::with(array('user'=>function($query){
            $query->select('id','name');
        },'category'))
        ->where('title', 'LIKE', "%$searchquery%")
        ->orWhere('description', 'LIKE', "%$searchquery%")->get();
        return response()->json([
            'posts'=> $posts
        ], 200 );

    }
}   
