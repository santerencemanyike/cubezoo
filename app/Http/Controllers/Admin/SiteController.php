<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Requests\MassDestroySiteRequest;
use App\Models\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
    // Web index view
    public function index()
    {
        abort_if(Gate::denies('site_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sites = Site::all();

        return view('admin.sites.index', compact('sites'));
    }

    // Web create view
    public function create()
    {
        abort_if(Gate::denies('site_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sites.create');
    }

    // Web + API store
    public function store(StoreSiteRequest $request)
    {
        $site = Site::create($request->validated());

        if(request()->wantsJson()) {
            return response()->json($site, 201);
        }

        return redirect()->route('admin.sites.index');
    }

    // Web show view
    public function show(Site $site)
    {
        abort_if(Gate::denies('site_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sites.show', compact('site'));
    }

    // Web edit view
    public function edit(Site $site)
    {
        abort_if(Gate::denies('site_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // reuse front-end edit form
        return view('sites.edit', compact('site'));
    }

    // Web update action
    public function update(UpdateSiteRequest $request, Site $site)
    {
        $site->update($request->validated());

        return redirect()->route('admin.sites.index');
    }

    // Web delete action
    public function destroy(Site $site)
    {
        abort_if(Gate::denies('site_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->delete();

        return back();
    }

    // Ajax mass delete
    public function massDestroy(MassDestroySiteRequest $request)
    {
        $sites = Site::find(request('ids'));

        foreach ($sites as $site) {
            $site->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}