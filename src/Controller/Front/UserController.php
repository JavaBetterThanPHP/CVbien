<?php
namespace App\Controller\Front;

use App\Entity\UserDiploma;
use App\Entity\UserLanguage;
use App\Entity\UserProgLanguage;
use App\Entity\UserSociety;
use App\Form\UserDiplomaFrontType;
use App\Form\ResetPasswordType;
use App\Form\UserFrontType;
use App\Form\UserLanguageFrontType;
use App\Form\UserProgLanguageFrontType;
use App\Form\UserSocietyTypeFront;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordType;
use Symfony\Component\Form\FormError;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * @Route("/
     filePicture", name="updateProfilePicture", methods={"POST"})
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
     * @Route("/updatePro", name="updatePro", methods={"GET","POST"})
     */
    public function updatePro(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $userProgLanguage = new UserProgLanguage();
        $userProgLanguage->setUser($user);
        $formUserProgLanguage = $this->createForm(UserProgLanguageFrontType::class, $userProgLanguage);

        $userLanguage = new UserLanguage();
        $userLanguage->setUser($user);
        $formUserLanguage = $this->createForm(UserLanguageFrontType::class, $userLanguage);


        if($request->request->has($formUserProgLanguage->getName())){
            $formUserProgLanguage->handleRequest($request);
            if ($formUserProgLanguage->isSubmitted() && $formUserProgLanguage->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userProgLanguage);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->clear();
                return $this->redirectToRoute('front_user_updatePro');
            }elseif ($formUserProgLanguage->isSubmitted() && !$formUserProgLanguage->isValid()) {
                $this->addFlash('error', 'Something went wrong. Are you sure this is a valid technology ?');
            }
        }elseif($request->request->has($formUserLanguage->getName())) {
            $formUserLanguage->handleRequest($request);
            if ($formUserLanguage->isSubmitted() && $formUserLanguage->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userLanguage);
                $entityManager->flush();
                return $this->redirectToRoute('front_user_updatePro');
            }
        }
        return $this->render('Front/user/user_update_info_pro.html.twig', [
            'user' => $user,
            'formUserProgLanguageFront' => $formUserProgLanguage->createView(),
            'formUserLanguageFront' => $formUserLanguage->createView(),
        ]);
    }
  

    /**
     * @Route("userProgLanguageDelete/{id}", name="progLanguageDelete", methods={"DELETE"})
     */

    public function userProgLanguageDelete(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userProgLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProgLanguage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_updatePro');
    }

    /**
     * @Route("userProgLanguageEdit/{id}", name="progLanguageEdit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userProgLanguageEdit(Request $request, UserProgLanguage $userProgLanguage): Response
    {
        $form = $this->createForm(UserProgLanguageFrontType::class, $userProgLanguage, [
            'action' => $this->generateUrl('front_user_progLanguageEdit', ['id' => $userProgLanguage->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->clear();
            return $this->redirectToRoute('front_user_updatePro');
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Something went wrong. Are you sure this is a valid technology ?');
            return $this->redirectToRoute('front_user_updatePro');
        }
        return $this->render('Front/user/_modal_user_progLanguage_edit.html.twig', [
            'formEditProgLanguage' => $form->createView(),
        ]);
    }

    /**
     * @Route("userLanguageDelete/{id}", name="languageDelete", methods={"DELETE"})
     */
    public function userLanguageDelete(Request $request, UserLanguage $userLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userLanguage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_updatePro');
    }

    /**
     * @Route("userLanguageEdit/{id}", name="languageEdit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userLanguageEdit(Request $request, UserLanguage $userLanguage): Response
    {
        $form = $this->createForm(UserLanguageFrontType::class, $userLanguage, [
            'action' => $this->generateUrl('front_user_languageEdit', ['id' => $userLanguage->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_updatePro');
        }
        return $this->render('Front/user/_modal_user_language_edit.html.twig', [
            'formEditLanguage' => $form->createView(),
        ]);
    }
    /**
     * @Route("/updateExp", name="updateExp", methods={"GET","POST"})
     */
    public function updateExp(Request $request): Response
    {
        $user = $this->getUser();
        $userSociety = new UserSociety();
        $userSociety->setUser($user);
        $formUserSocietyFront = $this->createForm(UserSocietyTypeFront::class, $userSociety);
        $formUserSocietyFront->handleRequest($request);
        if ($formUserSocietyFront->isSubmitted() && $formUserSocietyFront->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userSociety);
            $entityManager->flush();
            return $this->redirectToRoute('front_user_updateExp');
        }
        return $this->render('Front/user/user_update_info_society.html.twig', [
            'user' => $user,
            'formUserSocietyFront' => $formUserSocietyFront->createView(),
        ]);
    }
    /**
     * @Route("userExpDelete/{id}", name="expDelete", methods={"DELETE"})
     */
    public function useExpDelete(Request $request, UserSociety $userSociety): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userSociety->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userSociety);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_updateExp');
    }
    /**
     * @Route("userExpEdit/{id}", name="expEdit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userExpEdit(Request $request, UserSociety $userSociety): Response
    {
        $form = $this->createForm(UserSocietyTypeFront::class, $userSociety, [
            'action' => $this->generateUrl('front_user_expEdit', ['id' => $userSociety->getId()])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_updateExp');
        }
        return $this->render('Front/user/_modal_user_exp_edit.html.twig', [
            'formEditExp' => $form->createView(),
        ]);
    }
    /**
     * @Route("/userUpdateDiploma", name="updateDiploma", methods={"GET","POST"})
     */
    public function getUpdateUserDiploma(Request $request): Response
    {
        $user = $this->getUser();
        $userDiploma = new UserDiploma();
        $userDiploma->setUser($user);
        $formUserDiplomaFront = $this->createForm(UserDiplomaFrontType::class, $userDiploma);
        $formUserDiplomaFront->handleRequest($request);
        if ($formUserDiplomaFront->isSubmitted() && $formUserDiplomaFront->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userDiploma);
            $entityManager->flush();
            return $this->redirectToRoute('front_user_updateDiploma');
        }
        return $this->render('Front/user/user_update_info_diploma.html.twig', [
            'user' => $user,
            'formUserDiplomaFront' => $formUserDiplomaFront->createView(),
        ]);
    }
    /**
     * @Route("userDiplomaDelete/{id}", name="diplomaDelete", methods={"DELETE"})
     */
    public function userDiplomaDelete(Request $request, UserDiploma $userDiploma): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userDiploma->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userDiploma);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_user_updateDiploma');
    }
    /**
     * @Route("userDiplomaEdit/{id}", name="diplomaEdit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function userDiplomaEdit(Request $request, UserDiploma $userDiploma): Response
    {
        $form = $this->createForm(UserDiplomaFrontType::class, $userDiploma, [
            'action' => $this->generateUrl('front_user_diplomaEdit',['id'=>$userDiploma->getId()] )
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_user_updateDiploma');
        }
        return $this->render('Front/user/_modal_user_diploma_edit.html.twig', [
            'formEditUserDiploma' => $form->createView(),
        ]);
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

    /**
     * @Route("/sendmail", name="sendmail", methods={"GET", "POST"})
     */
    public function sendMail(\Swift_Mailer $mailer)
    {
        exit;
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