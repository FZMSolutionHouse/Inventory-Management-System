<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\WelcomeEmail;


class MailController extends Controller
{
    public function SendEmail() {
        $to="ahmedtahirofficial@gmail.com";
        $msg="Welcome to Government Innovation Lab This is The INVENTORY MANAGAMENT SYSTEM";
        $subject="GIL Quetta";
        
    Mail::to($to)->send(new WelcomeEmail($msg,$subject));
    }
}
