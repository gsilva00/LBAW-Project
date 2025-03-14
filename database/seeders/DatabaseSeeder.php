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
        DB::statement('DROP SCHEMA lbaw24124 CASCADE;');
        DB::statement('CREATE SCHEMA lbaw24124;');

        $schemaExists = DB::select("SELECT schema_name FROM information_schema.schemata WHERE schema_name = 'lbaw24124'");
        if (empty($schemaExists)) {
            $this->command->error('Schema creation failed!');
            return;
        } else {
            $this->command->info('Schema created successfully!');
        }

        // Seed the schema
        $path = base_path('database/schema.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $this->command->info('Schema seeded!');

        // Seed the data
        $dataPath = base_path('database/populate.sql');
        $dataSql = file_get_contents($dataPath);
        DB::unprepared($dataSql);
        $this->command->info('Data populated!');
    }
}
