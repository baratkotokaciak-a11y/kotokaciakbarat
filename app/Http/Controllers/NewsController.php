<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the news articles.
     */
    public function index()
    {
        $news = News::orderBy('date', 'desc')->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news article.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'type'    => 'nullable|string|max:100',
            'topic'   => 'nullable|string|max:150',
            'author'  => 'nullable|string|max:150',
            'editor'  => 'nullable|string|max:150',
            'date'    => 'nullable|date',
            'summary' => 'nullable|string|max:1500',
            'body'    => 'nullable|string',
            'image'   => 'nullable|image|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/news', 'public');
            $validated['image'] = $path; // store relative path
        }

        News::create($validated);

        return Redirect::route('news.index')
            ->with('success', 'Berita berhasil disimpan.');
    }

    /**
     * Display the specified news article.
     */
    public function show(News $news)
    {
        return Redirect::route('news.detail', $news->id);
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'type'    => 'nullable|string|max:100',
            'topic'   => 'nullable|string|max:150',
            'author'  => 'nullable|string|max:150',
            'editor'  => 'nullable|string|max:150',
            'date'    => 'nullable|date',
            'summary' => 'nullable|string|max:1500',
            'body'    => 'nullable|string',
            'image'   => 'nullable|image|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        // Delete old image if it exists
        if ($request->hasFile('image') && $news->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($news->image);
        }
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/news', 'public');
            $validated['image'] = $path; // store relative path
        }


        $news->update($validated);

        return Redirect::route('news.edit', $news->id)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(News $news)
    {
        $news->delete();
        return Redirect::route('news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
