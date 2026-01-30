@extends('layouts.app')

@section('title', 'Edit Todo')
@section('page-title', 'Edit Todo')

@section('content')
    <div class="form-container">
        <form method="POST" action="{{ route('todos.update', $todo) }}" class="todo-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title" class="form-label">Title *</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="form-input" 
                    value="{{ old('title', $todo->title) }}" 
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
                >{{ old('description', $todo->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">No Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $todo->category_id) == $category->id ? 'selected' : '' }}>
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
                        value="{{ old('due_date', $todo->due_date?->format('Y-m-d')) }}"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="pending" {{ old('status', $todo->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $todo->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $todo->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">Priority *</label>
                    <select id="priority" name="priority" class="form-select" required>
                        <option value="low" {{ old('priority', $todo->priority) === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $todo->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $todo->priority) === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority', $todo->priority) === 'urgent' ? 'selected' : '' }}>Urgent</option>
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
                                {{ in_array($tag->id, old('tags', $todo->tags->pluck('id')->toArray())) ? 'checked' : '' }}
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
                <button type="submit" class="btn btn-primary">Update Todo</button>
            </div>
        </form>
    </div>
@endsection
