<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Http\Requests\MassDestroyVisitRequest;
use App\Models\Visit;
use App\Models\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\ProcessVisitSubmission;

class VisitController extends Controller
{
    // Web index view (for admin, per site)
    public function index()
    {
        abort_if(Gate::denies('visit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Get all visits, eager load user & site
        $visits = Visit::with(['user', 'site'])
            ->orderBy('visited_at', 'desc')
            ->paginate(20);

        return view('admin.visits.index', compact('visits'));
    }

    // Web create view
    public function create(Site $site)
    {
        abort_if(Gate::denies('visit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visits.create', compact('site'));
    }

    // Web + API store (staff only)
    public function store(StoreVisitRequest $request)
    {
        $visit = Visit::create([
            'site_id' => $request->site_id,
            'user_id' => auth()->id(),
            'visited_at' => $request->visited_at,
            'notes' => $request->notes,
            'status' => 'draft'
        ]);

        if(request()->wantsJson()) {
            return response()->json($visit, 201);
        }

        return redirect()->route('admin.visits.index', $visit->site_id);
    }

    // Web + API submit
    public function submit(Visit $visit)
    {
        abort_if($visit->user_id !== auth()->id(), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($visit->status === 'submitted') {
            return response()->json(['message' => 'Already submitted']);
        }

        $visit->update(['status' => 'submitted']);

        ProcessVisitSubmission::dispatch($visit);

        if(request()->wantsJson()) {
            return response()->json($visit);
        }

        return redirect()->route('admin.visits.index', $visit->site_id);
    }

    // Web show view
    public function show(Visit $visit)
    {
        abort_if(Gate::denies('visit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visits.show', compact('visit'));
    }

    // Web edit view
    public function edit(Visit $visit)
    {
        abort_if(Gate::denies('visit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        abort_if($visit->status === 'submitted', Response::HTTP_FORBIDDEN, 'Cannot edit submitted visits');

        $sites = Site::all();

        return view('admin.visits.edit', compact('visit', 'sites'));
    }

    // Web update action
    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        abort_if($visit->status === 'submitted', Response::HTTP_FORBIDDEN, 'Cannot edit submitted visits');

        $visit->update($request->validated());

        return redirect()->route('admin.visits.index', $visit->site_id);
    }

    // Web delete action
    public function destroy(Visit $visit)
    {
        abort_if(Gate::denies('visit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visit->delete();

        return back();
    }

    // Ajax mass delete
    public function massDestroy(MassDestroyVisitRequest $request)
    {
        $visits = Visit::find(request('ids'));

        foreach ($visits as $visit) {
            $visit->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}