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
    public function index(\Symfony\Component\HttpFoundation\Request $request){

      /* if (isset($_GET['maVariable'])){
            $ajax = $_GET['maVariable'];
        var_dump($ajax);
        }*/
        if (isset($_POST['name'])) {
            var_dump($_POST['name']);
            $name = $_POST['name'];
            $json ="{
    \"datasetid\": \"$name\",
    \"recordid\": \"543d89cfb0bc68031def878b65945a181f72d33b\",
    \"fields\": {
      \"commune\": \"TheoILLE\",
      \"adresse\": \"CHEMIN LAURENT\",
      \"code_com\": \"31022\",
      \"geo_point_2d\": [
        43.6629100020807,
        1.424044004058203
      ],
      \"dmt_type\": \"Verre\",
      \"geo_shape\": {
        \"type\": \"Point\",
        \"coordinates\": [
          1.424044004058203,
          43.6629100020807
        ]
      },
      \"id\": \"AUCVE5010\"
    },
    \"geometry\": {
      \"type\": \"Lol\",
      \"coordinates\": [
        1.424044004058203,
        43.6629100020807
      ]
    },
    \"record_timestamp\": \"2019-03-04T10:45:32+01:00\"
  }";
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