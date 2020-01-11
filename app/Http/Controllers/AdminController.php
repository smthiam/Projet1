<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use Symfony\Component\HttpFoundation\IpUtils;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{

    protected $repository;

    public function __construct(ImageRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('ajax')->only('destroy');
    }
    public function orphans()
    {
        $orphans = $this->repository->getOrphans ();
        $orphans->count = count($orphans);
        return view ('maintenance.orphans', compact ('orphans'));
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Application $app)
{
    $maintenance = $app->isDownForMaintenance();
    $ipChecked = true;
    $ip = $request->ip();
    if($maintenance) {
        $data = json_decode(file_get_contents($app->storagePath().'/framework/down'), true);
        $ipChecked = isset($data['allowed']) && IpUtils::checkIp($ip, (array) $data['allowed']);
    }
    return view ('maintenance.maintenance', compact ('maintenance', 'ip', 'ipChecked'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    if($request->maintenance) {
        Artisan::call ('down', $request->ip ? ['--allow' => $request->ip()] : []);
    } else {
        Artisan::call ('up');
    }
    return redirect()->route('maintenance.index')->with ('ok', __ ('Le mode a bien été actualisé.'));
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $this->repository->destroyOrphans ();
        return response ()->json ();
    }
}
