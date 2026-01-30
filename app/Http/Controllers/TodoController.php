<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of todos
     */
    public function index(Request $request)
    {
        $query = Todo::with(['category', 'tags'])
            ->where('user_id', 1); // Using user_id = 1 for now (no auth yet)

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $todos = $query->paginate(15);
        $categories = Category::all();
        $tags = Tag::all();

        // Stats
        $stats = [
            'total' => Todo::where('user_id', 1)->count(),
            'pending' => Todo::where('user_id', 1)->where('status', 'pending')->count(),
            'in_progress' => Todo::where('user_id', 1)->where('status', 'in_progress')->count(),
            'completed' => Todo::where('user_id', 1)->where('status', 'completed')->count(),
            'overdue' => Todo::where('user_id', 1)->overdue()->count(),
        ];

        return view('todos.index', compact('todos', 'categories', 'tags', 'stats'));
    }

    /**
     * Show the form for creating a new todo
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('todos.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created todo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['user_id'] = 1; // Using user_id = 1 for now

        $todo = Todo::create($validated);

        if ($request->has('tags')) {
            $todo->tags()->attach($request->tags);
        }

        return redirect()->route('todos.index')->with('success', 'Todo created successfully!');
    }

    /**
     * Show the form for editing the specified todo
     */
    public function edit(Todo $todo)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('todos.edit', compact('todo', 'categories', 'tags'));
    }

    /**
     * Update the specified todo
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $todo->update($validated);

        if ($request->has('tags')) {
            $todo->tags()->sync($request->tags);
        } else {
            $todo->tags()->detach();
        }

        return redirect()->route('todos.index')->with('success', 'Todo updated successfully!');
    }

    /**
     * Remove the specified todo
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully!');
    }

    /**
     * Toggle todo completion
     */
    public function toggleComplete(Todo $todo)
    {
        if ($todo->status === 'completed') {
            $todo->update([
                'status' => 'pending',
                'completed_at' => null,
            ]);
        } else {
            $todo->markAsCompleted();
        }

        return back()->with('success', 'Todo updated!');
    }
}
