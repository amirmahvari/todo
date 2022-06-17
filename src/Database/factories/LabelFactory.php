<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Amirmahvari\Todo\Models\Label::class, function (Faker $faker) {
    return [
        'label' => $faker->slug,
    ];
});
