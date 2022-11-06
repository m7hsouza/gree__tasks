<?php

use Illuminate\Database\Seeder;

class TaskStagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_stages')->delete();
        DB::table('task_stages')->insert([
            'id' => 1,
            'name' => 'to-do',
            'color' => '#53BCF3'
        ]);
        DB::table('task_stages')->insert([
            'id' => 2,
            'name' => 'in-progress',
            'color' => '#FD9E3E'
        ]);
        DB::table('task_stages')->insert([
            'id' => 3,
            'name' => 'done',
            'color' => '#4ECA6F'
        ]);
        $this->command->info('TaskStatuses table seeded!');
    }
}
