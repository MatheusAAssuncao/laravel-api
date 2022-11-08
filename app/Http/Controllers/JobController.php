<?php

namespace App\Http\Controllers;

use App\Models\Job;

class JobController extends Controller
{
    /**
     * It can be filtered by “role”, “level”, “contract”, “languages” and “tools”. You can
     * send multiple filters in a request (ex: “role” and “level”). You can send multiple values per
     * filter (ex: In level you can send the value for “Senior” and “Junior”).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::with('languages', 'tools')->get();
        return response()->json($jobs);
    }

    /**
     * An endpoint for the job detail. It should receive the job id and return it.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $job = Job::with('tools', 'languages')->find($id);

        return response()->json([
            'status' => true,
            'data' => $job
        ], 200);
    }
}
