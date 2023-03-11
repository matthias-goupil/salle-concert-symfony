<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher,FileUploader $fileUploader, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute("app");
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('isAdmin');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('profilePicture')->getData();
            if ($picture) {
                $pictureFileName = $fileUploader->upload($picture);
                $user->setProfilePicture($pictureFileName);
            }
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($user, true);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profil', name: 'app_user_profil', methods: ['GET'])]
    public function profil(): Response
    {
        $user = $this->getUser();
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil', name: 'app_user_delete_profil', methods: ['POST'])]
    public function deleteProfil(UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/liked', name: 'app_user_liked', methods: ['GET'])]
    public function liked(): Response
    {
        return $this->render('user/liked.html.twig', [
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if((in_array("ROLE_USER", $this->getUser()->getRoles()) && $user->getId() == $this->getUser()->getId()) || in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
        }
            return $this->redirectToRoute('app');

    }


    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, FileUploader $fileUploader): Response
    {
        if((in_array("ROLE_USER", $this->getUser()->getRoles()) && $user->getId() == $this->getUser()->getId()) || in_array("ROLE_ADMIN", $this->getUser()->getRoles())){

            $form = $this->createForm(UserType::class, $user,[
                'edit' => true
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $isAdmin = $form->get('isAdmin')->getData();
                $user->setRoles($isAdmin?["ROLE_ADMIN"]:[]);
                $picture = $form->get('profilePicture')->getData();
                if ($picture) {
                    $pictureFileName = $fileUploader->upload($picture);
                    $user->setProfilePicture($pictureFileName);
                }
                if($form->get('password')->getData()){
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
                }
                $userRepository->save($user, true);

                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }
        return $this->redirectToRoute('app');
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ((in_array("ROLE_USER", $this->getUser()->getRoles()) && $user->getId() == $this->getUser()->getId()) || in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
                $userRepository->remove($user, true);
            }

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app');
    }

}
