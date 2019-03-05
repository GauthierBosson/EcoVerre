<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 05/03/2019
 * Time: 10:05
 */

namespace App\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChatController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/index",name="index")
     */
    public function index()
    {


        return $this->render('index.html.twig', []);
    }

}