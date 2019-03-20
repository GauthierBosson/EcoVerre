<?php
/**
 * Created by PhpStorm.
 * User: WEBENOO
 * Date: 06/03/2019
 * Time: 10:24
 */

namespace App\Controller;


use App\Entity\Incidents;
use App\Entity\Trashs;
use App\Form\DataTransformer\TrashTransformer;
use App\Form\IncidentType;
use App\Repository\TrashRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrashController extends AbstractController
{
    /**
     *@Route("/trash",name="trash")
     */
    public function index(TrashRepository $trash, Request $request){


        if ($request->isMethod('POST')) {
            $trash->addElevationJson();
        }

        return $this->render('trash.html.twig',[]);

    }

    /**
     * @Route("trash/add_incidents/{reference_trash}",name="add_incidents")
     */
    public function addIncidents(Request $request, $reference_trash, TrashTransformer $transformer)
    {
        $form = $this->createForm(IncidentType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $incident = new Incidents();
            $ref = random_bytes(8);
            $trash = $this->getDoctrine()->getRepository(Trashs::class)->findOneBy(['reference'=>$reference_trash]);
            $idTrash = $trash->getId();
            $idTransform = $transformer->reverseTransform($idTrash);


            $cityTrash = $trash->getCity();

            $incident->setEmail($data['email']);
            $incident->setDescription($data['description']);
            $incident->setDate(new \DateTime('now'));
            $incident->setReference(substr($cityTrash, 0, 3 ) . 'ver' . bin2hex($ref));
            $incident->setCity($cityTrash);
            $incident->setTrash($idTransform);

            $em = $this->getDoctrine()->getManager();
            $em->persist($incident);
            $em->flush();

            $this->addFlash('success','Incident enregistré avec succès !');
            return $this->redirect($request->getUri());
        }
        return $this->render('incidents.html.twig',['form'=>$form->createView()]);
    }

}