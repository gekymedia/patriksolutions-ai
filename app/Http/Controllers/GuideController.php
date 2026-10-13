<?php

namespace App\Http\Controllers;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class GuideController extends Controller
{
    public function index()
    {
        $guides = config('guides', []);

        return view('pages.guides-index', compact('guides'));
    }

    public function show(string $slug)
    {
        $guides = config('guides', []);

        abort_unless(isset($guides[$slug]), 404);

        $guide = $guides[$slug];

        $path = resource_path("guides/{$slug}.md");
        $bodyHtml = is_file($path)
            ? (new GithubFlavoredMarkdownConverter())->convert(file_get_contents($path))->getContent()
            : '';

        // A few related guides (others), for internal linking.
        $related = collect($guides)
            ->except($slug)
            ->take(3);

        return view('pages.guide', compact('slug', 'guide', 'bodyHtml', 'related'));
    }
}
