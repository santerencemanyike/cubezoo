<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Resources\VisitResource;
use App\Jobs\ProcessVisitSubmission;

class VisitController extends Controller
{
    /**
     * List visits for the current user (staff can only see their own)
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin) {
            $visits = Visit::paginate();
        } else {
            $visits = Visit::where('user_id', $user->id)->paginate();
        }
        
        return VisitResource::collection($visits);
    }

    /**
     * Create a new visit (staff only)
     */
    public function store(StoreVisitRequest $request)
    {
        $visit = Visit::create([
            'site_id' => $request->site_id,
            'user_id' => auth()->id(),
            'visited_at' => $request->visited_at,
            'notes' => $request->notes,
            'status' => 'draft'
        ]);

        return new VisitResource($visit);
    }

    /**
     * Submit a visit (staff can only submit their own)
     */
    public function submit(Visit $visit)
    {
        abort_if($visit->user_id !== auth()->id(), 403, 'Forbidden');

        if ($visit->status === 'submitted') {
            return response()->json([
                'message' => 'Visit already submitted'
            ], 400);
        }

        $visit->update([
            'status' => 'submitted'
        ]);

        ProcessVisitSubmission::dispatch($visit);

        return new VisitResource($visit);
    }
}
