<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Remjob;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Remjob::class, function (Faker $faker) {

    $minSalary = $faker->numberBetween($min = 1000, $max = 5000);

    $companyName = $faker->unique()->company;

    $positionLocation = '';
    $locationCount = rand(1,3);
    for ($x = 0; $x < $locationCount; $x++) {
        $locationItem = $faker->randomElement([ $faker->country, 'EU', 'USA', 'Asia', 'WORLDWIDE']);
        if( $locationItem == 'WORLDWIDE' ) {
            $positionLocation = 'WORLDWIDE';
            break;
        }
        if( Str::contains('$positionLocation', '$locationItem') ) {
            continue;
        } 
        $positionLocation .= ' '.$locationItem;
    }

    return [
        'company_name'  => $companyName,
        'company_slug'  => Str::slug($companyName, '-'),
        'position'      => $faker->randomElement(['administrator', 'operator', 'developer', 'devops', 'designer', 'coach']),
        'category_id'   => $faker->randomElement(['1', '2', '3', '4', '5', '6']),
        'text'          => $faker->text($maxNbChars = 600),
        'apply_link'    => $faker->url,
        'min_salary'    => $minSalary,
        'max_salary'    => $minSalary * 2,
        'locations'     => $positionLocation,
        'company_logo'  => $faker->randomElement([
                                'logos/logo1.png',
                                'logos/logo2.png',
                                'logos/logo3.png',
                                'logos/logo4.png',
                                'logos/logo5.png',
                                null
                            ]),
    ];
});

