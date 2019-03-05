<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 05/03/2019
 * Time: 11:58
 */

namespace App\Services;


class BotServices
{
    public function handleHello()
    {
        $responses = ['Va te faire'];

        return $responses[array_rand($responses)];
    }

    public function handleGoodbye(){
        $responses = ['Oue c\'est sa casse toi','Au revoir'];

        return $responses[array_rand($responses)];
    }

}