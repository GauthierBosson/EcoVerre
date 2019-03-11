<?php
/**
 * Created by PhpStorm.
 * User: WEBENOO
 * Date: 06/03/2019
 * Time: 10:24
 */

namespace App\Controller;


use App\Repository\TrashRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrashController extends AbstractController
{
    /**
     *@Route("/trash",name="trash")
     */
    public function index(TrashRepository $trash, \Symfony\Component\HttpFoundation\Request $request){

        if ($request->isMethod('POST')) {
            $trash->addJsonObject();
        }
        return $this->render('trash.html.twig',[]);

    }

}