<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 15/03/2019
 * Time: 11:21
 */

namespace App\Controller;


use App\Entity\Trashs;
use App\Entity\Users;
use App\Repository\TrashRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @throws \Exception
     * @Route("/security/addi", name="add_admin")
     */

    public function addAdmin(TrashRepository $trash)
    {


        $file = file_get_contents('json/recup.js');

        $file = substr($file , 12);

        $file= json_decode($file,true);
        for ($i= 0 ; $i < count($file[0]['features']);$i++){
            set_time_limit(1600);
            //$gps = $file[0]['features'][$i]['geometry']['coordinates'][1].','. $file[0]['features'][$i]['geometry']['coordinates'][0];
            //  $gps = "https://api.jawg.io/elevations?locations=$gps&access-token=x8GoSSkA047qElaEnCgbEar6kYS5MgFtKdIOu9af2U5VRtmj0lddYe99DnVxczrj";
            //$gps = file_get_contents($gps);
            //$gps = json_decode($gps,true);
            //$gps= $gps[0]['elevation'];
            $maxCapacity =  $file[0]['features'][$i]['properties']['maxCapacity'];
            $commune =  $file[0]['features'][$i]['properties']['commune'];
            $address =  $file[0]['features'][$i]['properties']['adresse'];
            $reference =  $file[0]['features'][$i]['properties']['id'];
            $insee =  $file[0]['features'][$i]['properties']['code_com'];
            $lng =  $file[0]['features'][$i]['geometry']['coordinates'][0];
            $lat =  $file[0]['features'][$i]['geometry']['coordinates'][1];
            $altitude =  rand(0,100);
            $actualCapacity =  $file[0]['features'][$i]['properties']['actualCapacity'] ;
            $available =$file[0]['features'][$i]['properties']['available'] ;
            $damage = $file[0]['features'][$i]['properties']['damaged']  ;

            //array_push($file[0]['features'][$i]['geometry']['coordinates'],$gps);
            $entityManager = $this->getDoctrine()->getManager();

            $trash = new Trashs();
            $trash->setCity($commune);
            $trash->setAddress($address);
            $trash->setReference($reference);
            $trash->setInseeCode($insee);
            $trash->setLongitude($lng);
            $trash->setLatitude($lat);
            $trash->setAltitude($altitude);
            $trash->setActualCapacity($actualCapacity);
            $trash->setCapacityMax($maxCapacity);
            $trash->setAvailability($available);
            $trash->setDamage($damage);
            $entityManager->persist($trash);
            $entityManager->flush();


        }



        return new Response('user ajouté');
    }
}