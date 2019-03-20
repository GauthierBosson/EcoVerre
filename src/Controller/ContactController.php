<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @return Response
     * @Route("home",name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data = $form->getData();
            $admin = $data['admin'];
            $referent = $data['referent'];
            $email = $data['email'];
            $objet = $data['objet'];
            $message = $data['message'];

            if($admin === true) {
                $mail = (new \Swift_Message($objet))
                    ->setFrom($email)
                    ->setTo('admin@greenworld.com')
                    ->setBody($message

                    );


                $mailer->send($mail);
                $this->addFlash('success','Message envoyé avec succès !');
            }

            if($referent === true){
                $ville = $data['ville'];
                $currentReferent =$this->getDoctrine()->getRepository(Users::class)->find($ville);
                $emailReferent = $currentReferent->getEmail();


                $mail2 = (new \Swift_Message($objet))
                    ->setFrom($email)
                    ->setTo($emailReferent)
                    ->setBody($message

                    );


                $mailer->send($mail2);
                $this->addFlash('success2','Message envoyé avec succès !');

            }
            return $this->redirect($request->getUri());

        }

        return $this->render('index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}