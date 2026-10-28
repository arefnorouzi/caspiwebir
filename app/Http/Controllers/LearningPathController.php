<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function index()
    {
        return view('learning-paths.index', [
            'paths' => config('learning_paths', []),
        ]);
    }

    public function show(string $slug)
    {
        $path = config('learning_paths.' . $slug);

        abort_unless(is_array($path), 404);

        return view('learning-paths.show', [
            'path' => $path,
        ]);
    }
}
