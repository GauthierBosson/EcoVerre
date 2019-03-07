<?php

namespace App\Services;


class BotServices
{
    public function handleHello()
    {
        $responses = ['Bonjour','Salut, en quoi puis-je vous aider ?'];

        return $responses[array_rand($responses)];
    }


    public function handleIncident()
    {
        $responses = ['Le rapport d\'incidents se trouve sur la fiche technique de la benne à verre concernée.'];
        return $responses[array_rand($responses)];
    }

    public  function  handleReferend()
    {
        $responses = ['Le référend de votre ville est Théo Dacosta dit le malin','Le référend de votre ville est Jar jar binks, la clé de tout'];

        return $responses[array_rand($responses)];
    }

    public function handleReferend2()
    {
        $responses = ['En cas d\'incidents sur une benne, vous pouvez le rapporter via le rapport d\'incidents qui se trouve sur profil de la benne concernée'];

        return $responses[array_rand($responses)];
    }

}