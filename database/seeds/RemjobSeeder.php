<?php

use Illuminate\Database\Seeder;

class RemjobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Remjob::class, 10)->create();
    }
}
