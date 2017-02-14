<?php

namespace App\Http\Controllers;


use App\Post;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{

    public function getIndex()
    {
        $posts = Post::orderBy('id', 'desc')->limit(4)->get();
        return view('pages.welcome')->withPosts($posts);
    }

    public function getAbout()
    {

        $first = 'Alex';
        $last = 'Muller';
        $full = $first . ' ' . $last;
        $email = 'alex@muller.com';

        return view('pages.about')->withFullname($full)->withEmail($email);
    }

    public function getContact()
    {
        return view('pages.contact');
    }


    public function postContact(Request $request)
    {
        $this->validate($request, array(
            'email'   => 'required|email',
            'message' => 'min:10',
            'subject' => 'min:3|max:255'
        ));

        $data = [
            'email' => $request->email,
            'bodyMessage' => $request->message,
            'subject' => $request->subject,
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data){
            $message->from($data['email']);
            $message->to('alex@muller.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was Sent!');

        return redirect('contact');
    }

}