<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendMail(){
        Mail::to('momorrrr8188@gmail.com')->send(new SendgridMail());
        dd('Mail sent');
    }
}
