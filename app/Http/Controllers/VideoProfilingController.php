<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobLocation;
use App\Models\VideoProfiling;
use App\Repository\VideoProfilingRepository;

class VideoProfilingController extends Controller
{
    private $videoProfilingRepository;


    public function __construct(
        VideoProfilingRepository $videoProfilingRepository
    )

    {
        $this->middleware('auth');
        $this->videoProfilingRepository = $videoProfilingRepository;
    }

    public function list()
    {
        $internal_video_profilig =  VideoProfiling::where('order_type',VideoProfiling::INTERNAL)->get();
        return view('video_profiling.internal.list', compact('internal_video_profilig'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers =  User::where('user_type',User::CUSTOMER)->get();
        $locations =  JobLocation::getLocations();
        return view('video_profiling.internal.add', compact('customers','locations'));
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

    public function storeInternalProfiling(Request $request)
    {
        return $result = $this->videoProfilingRepository->postInternalVideoProfiling($request->all());
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
