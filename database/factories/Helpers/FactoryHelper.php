<?php

namespace Database\Factories\Helpers;


// This function will get a random model id from the database 
class FactoryHelper
{
    public static function getRandomModelId(string $model)
    {
        // get model count
        $count = $model::query()->count();
        if ($count === 0) {
            // create a new record and retrieve the record id
            // if model count = 0
            return $model::factory()->create()->id;
        } else {
            // generate random number between 1 and model count
            return rand(1, $count);
        }
    }
}
