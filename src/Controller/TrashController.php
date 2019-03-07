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
            $address = '25 rue du bec';
            $zip = '76000';
            $url = 'https://nominatim.openstreetmap.org/search/25%20rue%20du%20bec%2076000?format=json&limit=1';
            $gps= file_get_contents($url,false,$context);
            $gps= json_decode($gps,true);
            var_dump($gps[0]['lat']);
            $name = $_POST['name'];
            $json ="{\"type\":\"Feature\",\"geometry\":{\"type\":\"Point\",\"coordinates\":[1.432351877926075,43.67490048623355]},
            \"properties\":{\"commune\":\"AUCAMVILLE\",\"adresse\":\"RUE DES CHENES\",\"code_com\":\"31022\",\"geo_point_2d\":[43.67490048623355,1.432351877926075],
            \"dmt_type\":\"Verre\",\"id\":\"AUCVE5002\"}}";


            $po = file_get_contents('recup.js');
            $po = substr($po , 12);
            var_dump($po);
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