<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitResource;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    public function index(Request $request, Site $site)
    {
        $query = $site->visits();

        if ($request->from) {
            $query->whereDate('visited_at', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('visited_at', '<=', $request->to);
        }

        return VisitResource::collection($query->paginate());
    }
}