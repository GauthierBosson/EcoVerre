<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\ReferentPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferentController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/user/addPassword/{hashKey}/{hashEmail}", name="password_user")
     */
    public function addPassword(Request $request, $hashEmail, $hashKey)
    {
        $form = $this->createForm(ReferentPasswordType::class);
        $form->handleRequest($request);

        if($form-> isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $emailInput = $data['email'];
            $password = password_hash($data['password'],PASSWORD_BCRYPT);
            $keyInput = $data['key'];

            if(sha1($keyInput) === $hashKey && sha1($emailInput) === $hashEmail) {
                $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['email'=>$emailInput]);
                $user->setPassword($password);
                $em=$this->getDoctrine()->getManager();
                $em->flush();
            } else {
                return new Response('erreur');
            }
        }
        return $this->render('referent/addPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}