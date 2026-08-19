<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $courses = Course::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('courses'))
            ->header('Content-Type', 'application/xml');
    }
}
