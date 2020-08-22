<?php

namespace App\Http\Controllers;
use Auth;
use App\Contact;
use App\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allContact(){
        return Contact::with('user')->get();
    }



    
    public function userContact(){
    $id = Auth::user()->id;
    $user = User::find($id);
    $contacts = $user->contacts()->orderBy('id','desc')->get();
    return $contacts;
    }



    public function uploadContactImage(Request $request){
        $this->validate($request,[
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048'
        ]);
        $file = $request->file('file');
        $name = time().'.'.$request->file->getClientOriginalExtension();
        $upload_path= public_path('assets/images/contacts/');
        $file->move($upload_path,$name);
        return $name;
    }




    public function deleteContactImage(Request $request){
        $filename = $request->photo;
        $path = public_path('assets/images/contacts/').$filename;
        if(file_exists($path)){
            @unlink($path);
        }
        return 'Removed';
    }


    public function addContact(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' =>'email',
            'phone' => 'required|min:10|numeric',   
        ]);

        Contact::create([
            'contact_name' => $request->name,
            'description' => $request->description,
            'photo' => $request->photo,
            'email' => $request->email,
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        return [ 'message' => "Contact Added"];
    }



    //DELTE CONTACT


    public function deleteContact($id){
        $contact = Contact::find($id);
        $path = public_path('assets/images/contacts/');
        if($contact->photo){
            @unlink($path.$contact->photo);
        }
        $contact->delete();
    }

}
