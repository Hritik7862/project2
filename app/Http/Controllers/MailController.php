<?php



// use mail;
  
  namespace App\Http\Controllers;
  
  use Illuminate\Http\Request;

  use App\Mail\DemoMail;
   use Illuminate\Support\Facades\Facade;
   use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];
         
        Mail::to('batraritik879@gmail.com')->send(new DemoMail($mailData));
           
        dd("Email is sent successfully.");
    }
}

