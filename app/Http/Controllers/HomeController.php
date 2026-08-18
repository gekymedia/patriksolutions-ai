<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->orderBy('sort_order')
            ->withCount('lessons')
            ->take(6)
            ->get();

        return view('home', compact('courses'));
    }
}
