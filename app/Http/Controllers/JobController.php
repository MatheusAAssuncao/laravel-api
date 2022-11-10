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
        $jobs = Job::select(['id', 'logo', 'role', 'level', 'position', 'contract', 'postedAt']);

        if ($request->has('role')) {
            if (is_array($request->role)) {
                $jobs->whereIn('role', $request->role);
            } else {
                $jobs->where('role', $request->role);
            }
        }

        if ($request->has('level')) {
            if (is_array($request->level)) {
                $jobs->whereIn('level', $request->level);
            } else {
                $jobs->where('level', $request->level);
            }
        }

        if ($request->has('contract')) {
            if (is_array($request->contract)) {
                $jobs->whereIn('contract', $request->contract);
            } else {
                $jobs->where('contract', $request->contract);
            }
        }

        if ($request->has('languages')) {
            if (is_array($request->languages)) {
                $jobs->whereHas('languages', function ($query) use ($request) {
                    $query->whereIn('name', $request->languages);
                });
            } else {
                $jobs->whereHas('languages', function ($query) use ($request) {
                    $query->where('name', $request->languages);
                });
            }
        }

        if ($request->has('tools')) {
            if (is_array($request->tools)) {
                $jobs->whereHas('tools', function ($query) use ($request) {
                    $query->whereIn('name', $request->tools);
                });
            } else {
                $jobs->whereHas('tools', function ($query) use ($request) {
                    $query->where('name', $request->tools);
                });
            }
        }

        /**
         * You can sort by “postedAt” and “position” (ascending and descending). Unlike
         * filtering you can only sort by one field. “postedAt” descending should be considered the
         * default if no sorting is sent.
         */
        if ($request->has('sort') && in_array($request->has('sort'), ['postedAt', 'position'])) {
            $jobs->orderBy($request->sort, $this->_getValidOrder($request));
        } else {
            $jobs->orderBy('postedAt', $this->_getValidOrder($request));
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
        $columns = 
        $job = Job::with('tools', 'languages')->find($id);

        return response()->json([
            'status' => true,
            'data' => !empty($job) ? $job : []
        ], 200);
    }

    protected function _getValidOrder($request)
    {
        if (!$request->has('order') || is_array($request->order)) {
            return 'desc';
        }

        return in_array($request->order, ['asc', 'desc']) ? $request->order : 'desc';
    }
}
