<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;

class HomeController extends Controller
{
     /**
     * Show the galerie.
     *
     * @param  \App\Repositories\ImageRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function index(ImageRepository $repository)
    {
        $images = $repository->getAllImages ();

        return view ('home', compact ('images'));
    }
}
