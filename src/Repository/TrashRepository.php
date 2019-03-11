<?php
/**
 * Created by PhpStorm.
 * User: WEBENOO
 * Date: 11/03/2019
 * Time: 10:06
 */

namespace App\Repository;


class TrashRepository
{
    public function customHeader(){
        $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);
        return $context;
    }

    public function getCoordinates(){
        $context = $this->customHeader();
        $address = rawurlencode($_POST['address']); // changer en resultat de formulaire
        $zip = rawurlencode($_POST['zip']); // changer en resultat de formulaire
        $url = "https://nominatim.openstreetmap.org/search/$address%20$zip?format=json&limit=1";
        $gps= file_get_contents($url,false,$context);
        $gps= json_decode($gps,true);
        return $gps;
    }

    public function getCommuneInfo(){
        $communeName = $_POST['commune']; // changer en resultat de formulaire

        $commune = 'https://geo.api.gouv.fr/communes?nom='.$communeName;
        $commune = file_get_contents($commune);
        $commune = json_decode($commune, true);
    }

    public function generateIdTrash(){
        $communeName = $_POST['commune']; // changer en resultat de formulaire

        $idTrash = substr($communeName, 0 ,3). 'VE' . rand(100,999);
        $idTrash = strtoupper($idTrash);
        return $idTrash;
    }

}