<?php
/**
 * Created by PhpStorm.
 * User: gauthierbosson
 * Date: 04/03/2019
 * Time: 14:49
 */

namespace App\Controller;


use App\Form\UserLoginForm;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UserLoginController extends Controller
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
     * @Route("/user/login", name="user_login")
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(UserLoginForm::class, [
            'email' => $this->authenticationUtils->getLastUsername()
        ]);

        return $this->render('login.html.twig', [
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'form' => $form->createView(),
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logoutAction(): void
    {
        // Left empty intentionally because this will be handled by Symfony.
    }

    /**
     * @param GoogleAuthenticatorInterface $googleAuthenticator
     * @return Response
     * @Route("user/googleSecret", name="generate_user_google_secret")
     */
    public function googleSecret(GoogleAuthenticatorInterface $googleAuthenticator)
    {
        $user = $this->getUser();
        $userAuthState = $user->isGoogleAuthenticatorEnabled();
        dump($userAuthState);
        $em = $this->getDoctrine()->getManager();

        if ($userAuthState === true) {
            return new Response('Doublue authentification déjà activée');
        } else {
            $secret = $googleAuthenticator->generateSecret();
            $user->setGoogleAuthenticatorSecret($secret);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_qrcode');
        }
    }

    /**
     * @param GoogleAuthenticatorInterface $authenticator
     * @Route("user/qrcode", name="user_qrcode")
     */
    public function qrcode(GoogleAuthenticatorInterface $authenticator)
    {
        $user = $this->getUser();
        $url = $authenticator->getUrl($user);
        echo '<img src="'.$url.'" />';

        return new Response();
    }

    /**
     * @Route("user/disabletfa", name="user_disable_tfa")
     */
    public function disableGoogleAuth()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setGoogleAuthenticatorSecret(null);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('sonata_admin_dashboard');
    }

    /**
     * @return Response
     * @Route("/user/2fa/check",name="user_check_2fa")
     */
    public function check2fa(Request $request, GoogleAuthenticatorInterface $authenticator)
    {
        $form = $this->createFormBuilder()
            ->add('code', TextType::class)
            ->add('check', SubmitType::class, ['label' => 'Vérifier code'])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $key = $data['code'];

            $user = $this->getUser();

            if($authenticator->checkCode($user,$key)){

                $session = $this->get('session');
                $session->set('user_check',1);

                return $this->redirectToRoute('sonata_admin_dashboard');

            } else {
                $this->addFlash('danger','Erreur code');
            }
        }
        return $this->render('user/2fa.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}