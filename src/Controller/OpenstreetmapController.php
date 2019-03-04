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


     //   $p= file_get_contents("https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=recup-verre");
     //   $p = json_decode($p);
     //   $p = get_object_vars($p);

        // var_dump($p);
       // var_dump(get_object_vars($p));

        // $directory = $this->getParameter('kernel.root_dir') . '/Repository/json/';
        // $fileLocator = new FileLocator($directory);
         // $jsonFiles = $fileLocator->locate('recup-verre.geojson', null, false);


         $fp = file_get_contents('C:\xampp\htdocs\EcoVerre\src\Repository\json\recup-verre.geojson');
         $fp = json_decode($fp);
         dump($fp);


        return $this->render('openstreetmap/index.html.twig', [
            'controller_name' => 'OpenstreetmapController',
            'json' => $fp
        ]);



    }


}
