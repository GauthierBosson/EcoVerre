<?php
/**
 * Created by PhpStorm.
 * User: WEBENOO
 * Date: 11/03/2019
 * Time: 10:06
 */

namespace App\Repository;


use App\Entity\Trashs;

class TrashRepository
{
    public function customHeader(){
        $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);
        return $context;
    }

    public function getCoordinates($address,$zip){
        $context = $this->customHeader();
        $address = rawurlencode($address); // changer en resultat de formulaire
        $zip = rawurlencode($zip); // changer en resultat de formulaire
        $url = "https://nominatim.openstreetmap.org/search/$address,%20$zip?format=json&limit=1";
        $gps= file_get_contents($url,false,$context);
        $gps= json_decode($gps,true);
        return $gps;
    }

    public function getCommuneInfo( $communeName){
       // $communeName = $_POST['commune']; // changer en resultat de formulaire

        $commune = 'https://geo.api.gouv.fr/communes?nom='.$communeName;
        $commune = file_get_contents($commune);
        $commune = json_decode($commune, true);
        return $commune;
    }

    public function generateIdTrash( $communeName){
       // $communeName = $_POST['commune']; // changer en resultat de formulaire

        $idTrash = substr($communeName, 0 ,3). 'VE' . rand(100,999);
        $idTrash = strtoupper($idTrash);
        return $idTrash;
    }
    public function getCommuneCode( $communeName){
        $commune = $this->getCommuneInfo( $communeName);
        $code_com = $commune[0]['code'];
        return $code_com;
    }
    public function generateTrashJson($communeName,$address,$zip,$maxCapacity,$actualCapacity,$available,$damaged ){
        $updatedAvailable = $this->falseToZero($available);
        $updatedDamaged = $this->falseToZero($damaged);

        $gps = $this->getCoordinates($address,$zip);
        $lat = $gps[0]['lat'];
        $lon = $gps[0]['lon'];
        //$communeName = $_POST['commune']; // changer en resultat de formulaire
       // $address = $_POST['address']; // changer en resultat de formulaire
        $idTrash = $this->generateIdTrash($communeName);
        $code_com = $this->getCommuneCode( $communeName);


        $json ='}},{"type":"Feature","geometry":{"type":"Point","coordinates":['.$lon.','.$lat.']},"properties":{"commune":"'.$communeName.'","adresse":"'.$address.'","code_com":'.$code_com.',"geo_point_2d":['.$lat.','.$lon.'],"dmt_type":"Verre","id":"'.$idTrash.'","maxCapacity":'.$maxCapacity.',"actualCapacity":'.$actualCapacity.',"available":'.$updatedAvailable.',"damaged":'.$updatedDamaged.',"zip":"'.$zip.'"}}]';
        return $json;
    }
    public function addJsonObject($communeName,$address,$zip,$maxCapacity,$actualCapacity,$available,$damaged){
        $json = $this->generateTrashJson($communeName,$address,$zip,$maxCapacity,$actualCapacity,$available,$damaged);
        $po = file_get_contents('json/recup.js');

        $to = strpos($po,'}}');
        $trans = array("}}]" => $json);
        $lo = strtr($po,$trans);

        $po = substr($lo , 12);
        $envoi = 'var Verre = '. $po;
        $file = fopen('json/recup.js','a');
        file_put_contents('json/recup.js',$envoi);
    }
    public function addElevationJson(){
        if (isset($_POST['reset'])){
            $file = file_get_contents('recup.js');

            $file = substr($file , 12);

            $file= json_decode($file,true);
            for ($i= 0 ; $i < count($file[0]['features']);$i++){
                set_time_limit(1600);
                //$gps = $file[0]['features'][$i]['geometry']['coordinates'][1].','. $file[0]['features'][$i]['geometry']['coordinates'][0];
              //  $gps = "https://api.jawg.io/elevations?locations=$gps&access-token=x8GoSSkA047qElaEnCgbEar6kYS5MgFtKdIOu9af2U5VRtmj0lddYe99DnVxczrj";
                //$gps = file_get_contents($gps);
                //$gps = json_decode($gps,true);
                //$gps= $gps[0]['elevation'];
                $file[0]['features'][$i]['properties']['maxCapacity'] = 2000;
                $file[0]['features'][$i]['properties']['actualCapacity'] = rand(0,2000);
                $file[0]['features'][$i]['properties']['available'] = rand(0,1);
                $file[0]['features'][$i]['properties']['damaged'] = rand(0,1);

                //array_push($file[0]['features'][$i]['geometry']['coordinates'],$gps);

            }
            $file =json_encode($file);
            $file = 'var Verre = '.$file;
            print_r($file);
            file_put_contents('json/recup.js',$file);
        }

    }

    public function falseToZero($value) {
        if ($value === false) {
            $value = 0;
            return $value;
        } else {
            return $value;
        }
    }
}