<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 16/03/2019
 * Time: 18:04
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(){
        return $this->render('index.html.twig', [ 'controller_name' => 'IndexController', ]);
    }

}