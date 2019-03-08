<?php
/**
 * Created by PhpStorm.
 * User: WEBENOO
 * Date: 06/03/2019
 * Time: 10:24
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrashController extends AbstractController
{
    /**
     *@Route("/trash",name="trash")
     */
    public function index(){


      /* if (isset($_GET['maVariable'])){
            $ajax = $_GET['maVariable'];
        var_dump($ajax);
        }*/
        if (isset($_POST['name'])) {
            $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
            $context = stream_context_create($opts);
            $address = '25 rue du bec'; // changer en resultat de formulaire
            $zip = '76000'; // changer en resultat de formulaire
            $url = 'https://nominatim.openstreetmap.org/search/25%20rue%20du%20bec%2076000?format=json&limit=1';
            $gps= file_get_contents($url,false,$context);
            $gps= json_decode($gps,true);
            $lat = $gps[0]['lat'];
            $lon = $gps[0]['lon'];
            $communeName = 'Colomiers'; // changer en resultat de formulaire

            $commune = 'https://geo.api.gouv.fr/communes?nom='.$communeName;
            $commune = file_get_contents($commune);
            $commune = json_decode($commune, true);
            $code_com = $commune[0]['code'];
            $idTrash = substr($communeName, 0 ,3). 'VE' . rand(100,999);
            $idTrash = strtoupper($idTrash);
            var_dump($idTrash);
            $name = $_POST['name'];
            $json ="{\"type\":\"Feature\",\"geometry\":{\"type\":\"Point\",\"coordinates\":[$lon,$lat},
            \"properties\":{\"commune\":\"$communeName\",\"adresse\":\"$address\",\"code_com\":\"$code_com\",\"geo_point_2d\":[$lat,$lon],
            \"dmt_type\":\"Verre\",\"id\":\"$idTrash\"}}";


            $po = file_get_contents('recup.js');
            $po = substr($po , 12);
            $po = json_decode($po , true);
            $pa =  array_push($po[0]['features'],$json);
            $pa = json_encode($po);
            $envoi = 'var Verre = '. $pa;
            $file = fopen('recup.js','a');
          //  fwrite($file,$envoi);
            file_put_contents('recup.js',$envoi);


        }



        return $this->render('trash.html.twig',[]);

    }

}