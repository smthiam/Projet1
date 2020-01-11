<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(){
        return \view('contact');
    }

    public function store(Request $request){
        $formRequest = [
            'email' => $request ->input('email'),
            'object' =>$request->input('object'),
            'message' => $request ->input('message')
        ];
        dd($formRequest);
        return \view('contact');

    }
    
}
