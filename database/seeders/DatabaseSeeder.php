<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Drop existing tables
        DB::statement('DROP SCHEMA public CASCADE;');
        DB::statement('CREATE SCHEMA public;');

        // Seed the schema
        $path = base_path('sql/schema.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $this->command->info('Schema seeded!');

        // Seed the data
        $dataPath = base_path('sql/populate.sql');
        $dataSql = file_get_contents($dataPath);
        DB::unprepared($dataSql);
        $this->command->info('Data populated!');
    }
}
