<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Remjob;
use Faker\Generator as Faker;


$factory->define(Remjob::class, function (Faker $faker) {

    $minSalary = $faker->numberBetween($min = 1000, $max = 5000);

    return [
        'company_name'  => $faker->company,
        'position'      => $faker->randomElement(['administrator', 'operator', 'developer', 'devops', 'designer', 'coach']),
        'category_id'   => $faker->randomElement(['1', '2', '3', '4', '5', '6']),
        'text'          => $faker->text($maxNbChars = 200),
        'apply_link'    => $faker->url,
        'show_salary'   => $faker->randomElement([false, true]),
        'salary_type'   => $faker->randomElement(['yearly', 'monthly', 'weekly', 'hourly']),
        'min_salary'    => $minSalary,
        'max_salary'    => $minSalary * 2,
        'location'      => $faker->country,
    ];
});

