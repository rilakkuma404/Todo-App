<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of tags
     */
    public function index()
    {
        $tags = Tag::withCount('todos')->get();
        return view('tags.index', compact('tags'));
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'color' => 'required|string|max:7',
        ]);

        Tag::create($validated);

        return back()->with('success', 'Tag created successfully!');
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'color' => 'required|string|max:7',
        ]);

        $tag->update($validated);

        return back()->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag deleted successfully!');
    }
}
