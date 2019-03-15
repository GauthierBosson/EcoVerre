<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 15/03/2019
 * Time: 11:21
 */

namespace App\Controller;


use App\Entity\Users;
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
     * @Route("/security/add", name="add_admin")
     */

    public function addAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $admin = new Users();
        $admin->setName('Revert');
        $admin->setFirstname('Romain');
        $admin->setEmail('Roro@gmail.com');
        $admin->setPassword($passwordEncoder->encodePassword($admin,'123456'));
        $admin->setRoles('ROLE_USER');
        $admin->setCity('Toulouse');
        $admin->setDateCreation(new \DateTime('now'));


        $entityManager->persist($admin);
        $entityManager->flush();

        return new Response('admin ajouté');
    }
}