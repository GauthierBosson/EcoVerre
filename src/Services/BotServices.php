<?php

namespace App\Services;

use App\Entity\Users;
use BotMan\BotMan\Users\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BotServices extends AbstractController
{

    public function handleHello()
    {
        $responses = ['Bonjour', 'Salut, en quoi puis-je vous aider ?'];

        return $responses[array_rand($responses)];
    }


    public function handleIncident()
    {
        $responses = ['Le rapport d\'incidents se trouve sur la fiche technique de la benne à verre concernée.'];
        return $responses[array_rand($responses)];
    }

    public function handleReferent()
    {
        $responses = ['Quelle ville ?'];

        return $responses[array_rand($responses)];
    }

    public function handleReferent2()
    {
        $responses = ['En cas d\'incidents sur une benne, vous pouvez le rapporter via le rapport d\'incidents qui se trouve sur profil de la benne concernée'];

        return $responses[array_rand($responses)];
    }

    public function handleAskReferent()
    {
        $user =$this->getDoctrine()->getRepository(Users::class)->findOneBy(['city' => 'Toulouse']);
        $name = $user->getName();
        $firstname = $user->getFirstname();

        $responses = ['Le référent de Toulouse est ' .$name .' ' .$firstname ];

        return $responses[array_rand($responses)];
    }
    public function handleAskReferent3()
    {
        $user =$this->getDoctrine()->getRepository(Users::class)->findOneBy(['city' => 'Rouen']);
        $name = $user->getName();
        $firstname = $user->getFirstname();

        $responses = ['Le référent de Rouen est ' .$name .' ' .$firstname ];

        return $responses[array_rand($responses)];
    }

    public function handleHelp()
    {
        $responses = ['Voici la liste des questions que vous pouvez poser : 
                       - Où se trouve le rapport d\'incident 
                       - Qui est le référent de ma ville 
                       - Qui prévenir en cas d\'incidents'];

        return $responses[array_rand($responses)];

    }

}