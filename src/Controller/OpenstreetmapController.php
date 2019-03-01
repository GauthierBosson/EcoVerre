<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OpenstreetmapController extends AbstractController
{
    /**
     * @Route("/openstreetmap", name="openstreetmap")
     */
    public function index()
    {
        return $this->render('openstreetmap/index.html.twig', [
            'controller_name' => 'OpenstreetmapController',
        ]);
    }
}
