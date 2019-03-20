<?php


namespace App\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BotConttoller extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/chat",name="chat")
     */
    public function chat()
    {
        return $this->render('chat.html.twig', []);
    }

}