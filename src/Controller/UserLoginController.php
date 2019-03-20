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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UserLoginController extends Controller
{

    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    private $router;

    public function __construct(AuthenticationUtils $authenticationUtils, RouterInterface $router)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->router = $router;
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
     * @Route("admin/googleSecret", name="generate_user_google_secret")
     */
    public function googleSecret(GoogleAuthenticatorInterface $googleAuthenticator, Request $request)
    {
        $user = $this->getUser();
        $userAuthState = $user->isGoogleAuthenticatorEnabled();
        $session = new Session();
        $sessionArr = $session->all();
        $em = $this->getDoctrine()->getManager();

        if ($userAuthState === true) {
            return new Response('Double authentification déjà activée');
        } else {
            $form = $this->createFormBuilder()
                ->add('code', TextType::class)
                ->add('save', SubmitType::class, ['label' => 'Valider'])
                ->getForm();

            $form->handleRequest($request);

            if ($session->has('secret')) {
                $secret = $sessionArr['secret'];
                $user->setGoogleAuthenticatorSecret($secret);
                $url = $googleAuthenticator->getUrl($user);

                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $userCode = $data['code'];

                    if ($googleAuthenticator->checkCode($user, $userCode)) {
                        $em->persist($user);
                        $em->flush();
                        $session->clear();

                        $this->addFlash('success', 'Double authentifiation activée avec succès. Veuillez vous reconnecter');

                        return new RedirectResponse($this->router->generate('admin_logout'));
                    }

                    $this->addFlash('error', 'Le code est invalide');
                }

                return $this->render('user/qrcode_view.html.twig', [
                    'url' => $url,
                    'form' => $form->createView()
                ]);
            } else {
                $secret = $googleAuthenticator->generateSecret();
                $user->setGoogleAuthenticatorSecret($secret);
                $session->set('secret', $secret);
                $url = $googleAuthenticator->getUrl($user);

                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $userCode = $data['code'];

                    if ($googleAuthenticator->checkCode($user, $userCode)) {
                        $em->persist($user);
                        $em->flush();
                        $session->clear();

                        $this->addFlash('success', 'Double authentifiation activée avec succès. Veuillez vous reconnecter');

                        return new RedirectResponse($this->router->generate('admin_logout'));
                    }

                    $this->addFlash('error', 'Le code est invalide');
                }

                return $this->render('user/qrcode_view.html.twig', [
                    'url' => $url,
                    'form' => $form->createView()
                ]);
            }
        }
    }

    /**
     * @param GoogleAuthenticatorInterface $authenticator
     * @Route("user/qrcode", name="user_qrcode")
     */
    public function qrcode(GoogleAuthenticatorInterface $authenticator): RedirectResponse
    {
        $user = $this->getUser();
        /*$secret = $user->getGoogleAuthenticatorSecret();
        dump($secret);
        die();
        $url = $authenticator->getUrl($user);
        return $this->render('user/qrcode_view.html.twig', [
            'url' => $url
        ]);*/
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
    }

    /**
     * @Route("admin/disabletfa", name="user_disable_tfa")
     */
    public function disableGoogleAuth()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setGoogleAuthenticatorSecret(null);
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Double authentification supprimée avec succès');
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