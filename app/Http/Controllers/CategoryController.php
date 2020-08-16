<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    //
    public function addCategory(Request $request){
        $this->validate($request,[
            'category_name' => 'required | min:3'
        ]);
        $create = Category::create([
            'category_name' => $request->category_name,
        ]);
        return response()->json([
            'message' => 'Created Succesfully'
        ], 200)  ;  
    }



    public function allCategory(){
         $categories = Category::orderBy('id','desc')->get();
         return response()->json([
            'categories' => $categories 
         ],200);
    }


    public function deleteCategory($id){
        return Category::find($id)->delete();
    }


    
    public function updateCategory( Request $request){
        $this->validate($request,[
            'category_name' => 'required | min:3'
        ]);
        $category =  Category::find($request->id);
        $category->category_name = $request->category_name;
        $category->save();
        return [
            'message' => 'Updated Successfully'
        ];
    }
}
