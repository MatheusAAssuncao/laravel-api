<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * It can be filtered by “role”, “level”, “contract”, “languages” and “tools”. You can
     * send multiple filters in a request (ex: “role” and “level”). You can send multiple values per
     * filter (ex: In level you can send the value for “Senior” and “Junior”).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobs = Job::with('languages', 'tools');

        if ($request->has('role')) {
            $jobs->where('role', $request->role);
        }

        if ($request->has('level')) {
            $jobs->where('level', $request->level);
        }

        if ($request->has('contract')) {
            $jobs->where('contract', $request->contract);
        }

        return response()->json([
            'status' => true,
            'data' => $jobs->get()
        ], 200);
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
            'data' => !empty($job) ? $job : []
        ], 200);
    }
}
