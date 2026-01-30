<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create a demo user
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Work', 'color' => '#3B82F6', 'description' => 'Work-related tasks'],
            ['name' => 'Personal', 'color' => '#10B981', 'description' => 'Personal tasks and errands'],
            ['name' => 'Shopping', 'color' => '#F59E0B', 'description' => 'Shopping lists'],
            ['name' => 'Health', 'color' => '#EF4444', 'description' => 'Health and fitness'],
            ['name' => 'Learning', 'color' => '#8B5CF6', 'description' => 'Learning and courses'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create tags
        $tags = [
            ['name' => 'Urgent', 'color' => '#DC2626'],
            ['name' => 'Important', 'color' => '#F59E0B'],
            ['name' => 'Quick', 'color' => '#10B981'],
            ['name' => 'Meeting', 'color' => '#3B82F6'],
            ['name' => 'Research', 'color' => '#8B5CF6'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Create sample todos
        $todos = [
            [
                'title' => 'Complete project proposal',
                'description' => 'Finish the Q1 project proposal and send it to the team for review',
                'category_id' => 1,
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(2),
                'tags' => [1, 2],
            ],
            [
                'title' => 'Team meeting at 2 PM',
                'description' => 'Weekly sync with the development team',
                'category_id' => 1,
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addHours(5),
                'tags' => [4],
            ],
            [
                'title' => 'Buy groceries',
                'description' => 'Milk, bread, eggs, fruits, vegetables',
                'category_id' => 3,
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDay(),
                'tags' => [3],
            ],
            [
                'title' => 'Gym workout',
                'description' => 'Leg day - squats, lunges, and cardio',
                'category_id' => 4,
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => now()->addHours(3),
                'tags' => [],
            ],
            [
                'title' => 'Finish Laravel course',
                'description' => 'Complete modules 8-10 of the Laravel mastery course',
                'category_id' => 5,
                'priority' => 'medium',
                'status' => 'in_progress',
                'due_date' => now()->addDays(5),
                'tags' => [5],
            ],
            [
                'title' => 'Code review for John',
                'description' => 'Review Johns pull request for the authentication module',
                'category_id' => 1,
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->addHours(2),
                'tags' => [1],
            ],
            [
                'title' => 'Update documentation',
                'description' => 'Update API documentation with new endpoints',
                'category_id' => 1,
                'priority' => 'low',
                'status' => 'completed',
                'due_date' => now()->subDays(1),
                'completed_at' => now()->subHours(5),
                'tags' => [],
            ],
            [
                'title' => 'Plan weekend trip',
                'description' => 'Research and book hotels for the weekend getaway',
                'category_id' => 2,
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => now()->addDays(3),
                'tags' => [5],
            ],
            [
                'title' => 'Fix production bug',
                'description' => 'Critical bug in payment processing needs immediate attention',
                'category_id' => 1,
                'priority' => 'urgent',
                'status' => 'in_progress',
                'due_date' => now()->addHours(1),
                'tags' => [1, 2],
            ],
            [
                'title' => 'Call dentist',
                'description' => 'Schedule appointment for teeth cleaning',
                'category_id' => 4,
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(7),
                'tags' => [],
            ],
        ];

        foreach ($todos as $todoData) {
            $tags = $todoData['tags'];
            unset($todoData['tags']);
            
            $todo = Todo::create([
                'user_id' => $user->id,
                ...$todoData
            ]);

            if (!empty($tags)) {
                $todo->tags()->attach($tags);
            }
        }
    }
}
