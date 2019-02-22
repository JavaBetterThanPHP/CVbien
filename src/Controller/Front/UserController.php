<?php

namespace App\Controller\Front;

use App\Form\UserFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ChangePasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * @Route("/", name="front_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserFrontType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_index');
        }

        return $this->render('Front/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

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
        } catch (exception $e) {

        }
        /*
        $form = $this->createForm(UserFrontType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_index');
        }else{
            return $this->render('Front/default/index.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        */
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
        } catch (exception $e) {

        }
        return new Response("ok");
    }

    /**
     * @Route("/sendmail", name="sendmail", methods={"GET", "POST"})
     */
    public function sendMail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('test'))
            ->setFrom('francois.roger@axa.fr')
            ->setTo('francois.roger@axa.fr')
            ->setBody("test");

        $logger = new \Swift_Plugins_Loggers_EchoLogger();
        $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));
        $resultCustomer = $mailer->send($message, $failures);


        dump($resultCustomer);

        return new JsonResponse("ok", 200);

    }

    /**
     * @Route("/reset-password", name="reset_password", methods={"GET", "POST"})
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        //dump($user);

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $request->request->get('change_password')['oldPassword'];
            $newPassword = $request->request->get('change_password')['plainPassword']['first'];

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
            'form' => $form->createView(),
        ));
    }
}