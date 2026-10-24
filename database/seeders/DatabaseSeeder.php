<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@example.com'],
            ['name' => 'Ravi', 'email' => 'ravi@example.com'],
            ['name' => 'Priya', 'email' => 'priya@example.com'],
            ['name' => 'Amit', 'email' => 'amit@example.com'],
        ];

        $titles = [
            'Install Docker Desktop',
            'Write the Dockerfile',
            'Create docker-compose.yml',
            'Push code to GitHub',
            'Create an AWS account',
            'Learn Terraform basics',
            'Set up Jenkins',
            'Write the Jenkinsfile',
            'Add Grafana dashboard',
            'Clean up AWS resources',
        ];

        foreach ($users as $index => $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => 'password',
            ]);

            $count = $index === 0 ? 10 : 5;

            foreach (array_slice($titles, 0, $count) as $number => $title) {
                Task::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'is_done' => $number < 2,
                ]);
            }
        }
    }
}
