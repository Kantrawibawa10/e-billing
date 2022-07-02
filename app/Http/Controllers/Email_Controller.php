<?php

namespace App\Http\Controllers;
use App\Mail\send_email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class Email_Controller extends Controller
{
    public function test_mailable_content()
    {

        Mail::to('kantrawibawa10@gmail.com')->send(new send_email());

    }


}
