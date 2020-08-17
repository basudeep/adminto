<?php

namespace App\Http\Controllers;
use Auth;
use App\Contact;
use App\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function allContact(){
        return Contact::with('user')->get();
    }



    
    public function userContact(){
    $id = Auth::user()->id;
    $user = User::find($id);
    $contacts = $user->contacts()->get();
    return $contacts;
    }
}
