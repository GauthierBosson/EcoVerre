<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\FileLocator;


class OpenstreetmapController extends AbstractController
{
    /**
     * @Route("/openstreetmap", name="openstreetmap")
     */
    public function index()
    {
        /* --  $configDirectories = [__DIR__.'../../Repository/json'];
        $fileLocator = new FileLocator($configDirectories);
        $jsonUserFiles = $fileLocator->locate('recup-verre.json', null, false); -- */

        $fp = fopen('C:\xampp\htdocs\EcoVerre\src\Repository\Json\recup-verre.geojson','r');
        dump($fp);

        return $this->render('openstreetmap/index.html.twig', [
            'controller_name' => 'OpenstreetmapController',
        ]);



    }


}
