<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Resources\SiteResource;
use App\Models\Site;

class SiteController extends Controller
{
    public function index()
    {
        return SiteResource::collection(Site::paginate());
    }

    public function store(StoreSiteRequest $request)
    {
        abort_if(!auth()->user()->isAdmin, 403, 'Forbidden');

        $site = Site::create($request->validated());

        return new SiteResource($site);
    }
}