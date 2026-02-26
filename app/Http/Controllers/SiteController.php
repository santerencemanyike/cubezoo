<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        Site::create($validated);

        return redirect()->route('admin.sites.index')
            ->with('success', 'Site created successfully');
    }

    public function show(Site $site)
    {
        return view('sites.show', compact('site'));
    }

    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $site->update($validated);

        return redirect()->route('admin.sites.show', $site)
            ->with('success', 'Site updated successfully');
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return redirect()->route('admin.sites.index')
            ->with('success', 'Site deleted successfully');
    }
}