@extends('layouts.app')

@section('title', 'Tags')
@section('page-title', 'Tags')

@section('content')
    <!-- Create Tag Form -->
    <div class="card">
        <div class="card-header">
            <h3>Create New Tag</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('tags.store') }}" class="inline-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <input 
                            type="text" 
                            name="name" 
                            placeholder="Tag name" 
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
                            value="{{ old('color', '#6B7280') }}"
                            required
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">Add Tag</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tags List -->
    <div class="tags-grid">
        @forelse($tags as $tag)
            <div class="tag-card">
                <div class="tag-info">
                    <span class="tag-badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                        {{ $tag->name }}
                    </span>
                    <span class="tag-count">{{ $tag->todos_count }} todos</span>
                </div>
                <form method="POST" action="{{ route('tags.destroy', $tag) }}" class="inline-form" onsubmit="return confirm('Delete this tag?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete-btn" title="Delete">🗑️</button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">🏷️</div>
                <h3>No tags yet</h3>
                <p>Create your first tag to label your todos</p>
            </div>
        @endforelse
    </div>
@endsection
