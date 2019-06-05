<?php

namespace App\Controller;

use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserPasswordType;
use App\Form\UserPasswordPremiumType;
use App\Entity\User;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Security;




/**
 * Class UserController
 * @package App\Controller
 * @Route(name="app_security_")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/login/redirect", name="login_redirect")
     */
    public function login_redirect(Security $security)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        $currentDate = new \DateTime();
        $user = $security->getUser();

        $user->setDateDerniereConnexion($currentDate);

        $em->persist($user);
        $em->flush();


        if (in_array("ROLE_PREMIUM", $user->getRoles()))
        {
            return $this->redirectToRoute('front_research_index');
        }
        else {
            return $this->redirectToRoute('front_index');
        }

    }

    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        if ($this->getUser() instanceof User) {
            return $this->redirectToRoute('app_security_login');
        }
        $user = new User();
        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $currentDate = new \DateTime();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $user->setDateCreationCompte($currentDate);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Inscription CVBien'))
                ->setFrom('register@cvbien.io')
                ->setTo($user->getEmail())
                ->setBody("Bonjour, merci de votre inscription. Votre identifiant est votre mail et le mot de passe celui que vous venez de définir.");

            $mailer->send($message);
            //dump($user);exit;

            return $this->redirectToRoute('app_security_login');
        }
        return $this->render(
            'security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }


    /**
     * @Route("/forgot-password", name="forgot_password", methods={"GET", "POST"})
     */
    public function forgotPassword(Request $request, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $mailToReset = $request->request->get('forgot_password')['email'];
            $userToReset = $em->getRepository(User::class)->findOneBy(array('email' => $mailToReset));

            if ($userToReset)
            {
                $userToReset->setTokenToReset(bin2hex(random_bytes(20)));
                $em->persist($userToReset);
                $em->flush();

                $message = (new \Swift_Message('Mot de passe oublié - CVBien'))
                    ->setFrom('reset-password@cvbien.io')
                    ->setTo($mailToReset)
                    ->setBody('Pour réinitialiser votre password cliquez sur le lien suivant : 127.0.0.1:8000/reset/'.$userToReset->getEmail().'/'.$userToReset->getTokenToReset().'');

                $mailer->send($message);

                return $this->render('security/forgot_password_accepted.html.twig', array(
                        'form' => $form->createView()
                    )
                );
            }
            else
            {
                $form->addError(new FormError('Votre compte n\'existe pas'));
            }
        }

        return $this->render('security/forgot_password.html.twig', array(
            'form' => $form->createView()
            )
        );

    }

    /**
     * @Route("/reset/{email}/{token}", name="reset_forgot_password", methods={"GET", "POST"})
     */
    public function resetForgotPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, $email, $token)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(array('email' => $email));


        if ($user && $user->getTokenToReset()==$token && $token != null)
        {
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $newPassword = $request->request->get('reset_password')['plainPassword']['first'];
                $encodedPassword = $passwordEncoder->encodePassword($user, $newPassword);

                $user->setPassword($encodedPassword);
                $user->setTokenToReset(null);

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('front_index');
            }
            else
            {
                $this->addFlash('notice', 'Erreur lors de la saisie du mot de passe');
            }
        }
        else {
            throw $this->createNotFoundException('404');
        }

        return $this->render('security/forgot_reset_password.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/register/professional", name="register_professional", methods={"GET", "POST"})
     */
    public function registerPro(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserPasswordPremiumType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $currentDate = new \DateTime();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);
            $user->setDateCreationCompte($currentDate);

            /** difference compte premium */

            $user->setRoles(['ROLE_PREMIUM']);
            $user->setIsProfessional(true);
            dump(bin2hex(random_bytes(5)));
            $user->setSpaceName(bin2hex(random_bytes(5)));

            /** fin difference */

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            /** @doc swift mailer: https://symfony.com/doc/current/email.html  */
            /** décommenter ici en PROD pour envoi de mail apres inscription */
            /**
            $message = (new \Swift_Message('Inscription CVBien Premium'))
                ->setFrom('register@cvbien.io')
                ->setTo($user->getEmail())
                ->setBody("Bonjour, merci de votre inscription Premium. Votre identifiant est votre mail et le mot de passe celui que vous venez de définir. Vous pouvez visionner les CV de tous les développeurs.");

            $mailer->send($message);
            */

            return $this->redirectToRoute('app_security_login');
        }
        return $this->render(
            'security/register_pro.html.twig', [
                'form' => $form->createView()
            ]
        );

        //echo "register pro";die;
        //return $this->render('security/register_pro.html.twig', []);
    }
}
