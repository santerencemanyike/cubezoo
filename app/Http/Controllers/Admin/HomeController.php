<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use App\Models\Favourite;

class HomeController
{
    public function index()
    {
        $files = collect([
            ['name' => 'Resume 1', 'type' => 'PDF', 'size' => '120 KB'],
            ['name' => 'Resume 2', 'type' => 'DOCX', 'size' => '95 KB'],
            ['name' => 'Resume 3', 'type' => 'PDF', 'size' => '200 KB'],
        ]);

        // Pass the dummy data to the view
        return view('home', compact('files'));
    }
}
