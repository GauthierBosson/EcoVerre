<?php


namespace App\Controller;

use App\Entity\Users;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AdminLoginForm;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
final class AdminLoginController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(AdminLoginForm::class, [
            'email' => $this->authenticationUtils->getLastUsername()
        ]);

        return $this->render('admin/login.html.twig', [
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'form' => $form->createView(),
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function logoutAction(): void
    {
        // Left empty intentionally because this will be handled by Symfony.
    }

    /**
     * @return Response
     * @Route("/admin/2fa/check",name="check_2fa")
     */
    public function check2fa(Request $request, GoogleAuthenticatorInterface $authenticator)
    {
        $form = $this->createFormBuilder()
            ->add('code', TextType::class,[
                'attr'=>['class'=>'form-control']])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $key = $data['code'];

            $user = $this->getUser();

            if($authenticator->checkCode($user,$key)){

                $session = $this->get('session');
                $session->set('check',1);

                return $this->redirectToRoute('sonata_admin_dashboard');

            } else {
                $this->addFlash('danger','Erreur code');
            }
        }
        return $this->render('admin/2fa.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}