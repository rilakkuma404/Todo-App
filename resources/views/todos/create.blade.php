@extends('layouts.app')

@section('title', 'Create Todo')
@section('page-title', 'Create New Todo')

@section('content')
    <div class="form-container">
        <form method="POST" action="{{ route('todos.store') }}" class="todo-form">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">Title *</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="form-input" 
                    value="{{ old('title') }}" 
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-textarea" 
                    rows="4"
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">No Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input 
                        type="date" 
                        id="due_date" 
                        name="due_date" 
                        class="form-input"
                        value="{{ old('due_date') }}"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">Priority *</label>
                    <select id="priority" name="priority" class="form-select" required>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tags</label>
                <div class="tags-checkbox-group">
                    @foreach($tags as $tag)
                        <label class="tag-checkbox">
                            <input 
                                type="checkbox" 
                                name="tags[]" 
                                value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                            >
                            <span class="tag-label" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                                {{ $tag->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('todos.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Todo</button>
            </div>
        </form>
    </div>
@endsection
