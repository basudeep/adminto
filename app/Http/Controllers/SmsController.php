<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
class SmsController extends Controller
{
    //

    public function sendMessage(Request $request){
        $this->validate($request,[
            'phone' => 'required|min:10|numeric',
        ]);
        Nexmo::message()->send([
            'to'   => '91'.$request->phone,
            'from' => '9434999201',
            'text' => $request->message,
        ]);
        }
}
