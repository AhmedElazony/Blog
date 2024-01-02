<?php

namespace App\Http\Controllers;

use App\Services\MailchimpNewsletter;
use App\Services\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function __invoke(Newsletter $newsletter)
    {
        try {
            $newsletter->subscribe(request('email'));
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'This Email is not Valid!'
            ]);
        }

        return redirect('/')->with('success', 'You have benn subscribed to the newsletter!');
    }
}
