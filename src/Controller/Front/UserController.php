<?php

namespace App\Controller\Front;

use App\Form\ResetPasswordType;
use App\Form\UserFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/", name="front_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/updateProfilePicture", name="updateProfilePicture", methods={"POST"})
     */
    public function updateProfilePicture(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $user->setImageFile($request->files->get('data'));
            $entityManager->flush();
        } catch (\Exception $e) {
            return new Response('ko');
        }
        return new Response("ok");
    }

    /**
     * @Route("/updateBanner", name="updateBanner", methods={"POST"})
     */
    public function updateBanner(Request $request): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $user->setBannerImageFile($request->files->get('data'));
            $entityManager->flush();
        } catch (\Exception $e) {
            return new Response('ko');
        }
        return new Response("ok");
    }

    /**
     * @Route("/updateInfo", name="updateInfo", methods={"GET","POST"})
     */
    public function updateInfo(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $formUserFront = $this->createForm(UserFrontType::class, $user);
        $formUserFront->handleRequest($request);
        if ($formUserFront->isSubmitted() && $formUserFront->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_updateInfo');
        }
        return $this->render('Front/user/user_update_info_perso.html.twig', [
            'user' => $user,
            'formUserFront' => $formUserFront->createView(),
        ]);
    }

    /**
     * @Route("/resetpassword", name="reset_password", methods={"GET", "POST"})
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $request->request->get('reset_password')['oldPassword'];
            $newPassword = $request->request->get('reset_password')['plainPassword']['first'];

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
                $user->setPassword($newEncodedPassword);
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('front_index');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('Front/user/reset_password.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/sendmail", name="sendmail", methods={"GET", "POST"})
     */
    public function sendMail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('test'))
            ->setFrom('francois0roger@gmail.com')
            ->setTo('francois0roger@gmail.com')
            ->setBody("test");

        $logger = new \Swift_Plugins_Loggers_EchoLogger();
        $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));
        $resultCustomer = $mailer->send($message, $failures);
        dump($resultCustomer);

        return new JsonResponse("ok", 200);
    }

}