<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = ['contact_name','email','phone', 'description','photo','user_id','relation','address'];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
