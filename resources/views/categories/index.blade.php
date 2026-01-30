@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <!-- Create Category Form -->
    <div class="card">
        <div class="card-header">
            <h3>Create New Category</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('categories.store') }}" class="inline-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <input 
                            type="text" 
                            name="name" 
                            placeholder="Category name" 
                            class="form-input"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <input 
                            type="color" 
                            name="color" 
                            class="form-color"
                            value="{{ old('color', '#3B82F6') }}"
                            required
                        >
                    </div>
                    <div class="form-group flex-grow">
                        <input 
                            type="text" 
                            name="description" 
                            placeholder="Description (optional)" 
                            class="form-input"
                            value="{{ old('description') }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="categories-grid">
        @forelse($categories as $category)
            <div class="category-card" style="border-left: 4px solid {{ $category->color }};">
                <div class="category-info">
                    <div class="category-color" style="background-color: {{ $category->color }};"></div>
                    <div>
                        <h3 class="category-name">{{ $category->name }}</h3>
                        @if($category->description)
                            <p class="category-description">{{ $category->description }}</p>
                        @endif
                        <span class="category-count">{{ $category->todos_count }} todos</span>
                    </div>
                </div>
                <div class="category-actions">
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline-form" onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn" title="Delete">🗑️</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📁</div>
                <h3>No categories yet</h3>
                <p>Create your first category to organize your todos</p>
            </div>
        @endforelse
    </div>
@endsection
