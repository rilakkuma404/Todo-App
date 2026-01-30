@extends('layouts.app')

@section('title', 'My Todos')
@section('page-title', 'My Todos')

@section('header-actions')
    <a href="{{ route('todos.create') }}" class="btn btn-primary">
        <span>+</span> New Todo
    </a>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card stat-progress">
            <div class="stat-value">{{ $stats['in_progress'] }}</div>
            <div class="stat-label">In Progress</div>
        </div>
        <div class="stat-card stat-completed">
            <div class="stat-value">{{ $stats['completed'] }}</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card stat-overdue">
            <div class="stat-value">{{ $stats['overdue'] }}</div>
            <div class="stat-label">Overdue</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('todos.index') }}" class="filters-form">
            <div class="filter-group">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search todos..." 
                    value="{{ request('search') }}"
                    class="filter-input"
                >
            </div>

            <div class="filter-group">
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="all">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="filter-group">
                <select name="priority" class="filter-select" onchange="this.form.submit()">
                    <option value="all">All Priorities</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>

            <div class="filter-group">
                <select name="category_id" class="filter-select" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(request()->hasAny(['search', 'status', 'priority', 'category_id']))
                <a href="{{ route('todos.index') }}" class="btn btn-secondary">Clear Filters</a>
            @endif
        </form>
    </div>

    <!-- Todos List -->
    <div class="todos-grid">
        @forelse($todos as $todo)
            <div class="todo-card priority-{{ $todo->priority }} status-{{ $todo->status }} {{ $todo->isOverdue() ? 'overdue' : '' }}">
                <div class="todo-header">
                    <div class="todo-check">
                        <form method="POST" action="{{ route('todos.toggle', $todo) }}" class="inline-form">
                            @csrf
                            <button type="submit" class="check-btn {{ $todo->status === 'completed' ? 'checked' : '' }}">
                                @if($todo->status === 'completed')
                                    ✓
                                @endif
                            </button>
                        </form>
                    </div>
                    <div class="todo-priority-badge">
                        {{ ucfirst($todo->priority) }}
                    </div>
                </div>

                <div class="todo-body">
                    <h3 class="todo-title {{ $todo->status === 'completed' ? 'completed' : '' }}">
                        {{ $todo->title }}
                    </h3>
                    @if($todo->description)
                        <p class="todo-description">{{ Str::limit($todo->description, 100) }}</p>
                    @endif

                    <div class="todo-meta">
                        @if($todo->category)
                            <span class="todo-category" style="background-color: {{ $todo->category->color }}20; color: {{ $todo->category->color }};">
                                {{ $todo->category->name }}
                            </span>
                        @endif

                        @foreach($todo->tags as $tag)
                            <span class="todo-tag" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                                {{ $tag->name }}
                            </span>
                        @endforeach

                        @if($todo->due_date)
                            <span class="todo-due-date {{ $todo->isOverdue() ? 'overdue' : '' }}">
                                📅 {{ $todo->due_date->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="todo-footer">
                    <div class="todo-status">
                        <span class="status-badge status-{{ $todo->status }}">
                            {{ str_replace('_', ' ', ucfirst($todo->status)) }}
                        </span>
                    </div>
                    <div class="todo-actions">
                        <a href="{{ route('todos.edit', $todo) }}" class="action-btn edit-btn" title="Edit">
                            ✏️
                        </a>
                        <form method="POST" action="{{ route('todos.destroy', $todo) }}" class="inline-form" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn" title="Delete">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>No todos found</h3>
                <p>Create your first todo to get started!</p>
                <a href="{{ route('todos.create') }}" class="btn btn-primary">Create Todo</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($todos->hasPages())
        <div class="pagination-wrapper">
            {{ $todos->links() }}
        </div>
    @endif
@endsection
