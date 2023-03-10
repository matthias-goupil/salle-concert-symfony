<?php

namespace App\Controller;

use App\Entity\MusicGroup;
use App\Form\MusicGroupType;
use App\Repository\MusicGroupRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/musicGroup')]
class MusicGroupController extends AbstractController
{
    #[Route('/', name: 'app_music_group_index', methods: ['GET'])]
    public function index(MusicGroupRepository $musicGroupRepository): Response
    {
        return $this->render('music_group/index.html.twig', [
            'music_groups' => $musicGroupRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_music_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MusicGroupRepository $musicGroupRepository,TagRepository $tagRepository,FileUploader $fileUploader): Response
    {
        $musicGroup = new MusicGroup();
        $form = $this->createForm(MusicGroupType::class, $musicGroup,[
            "tags" => $tagRepository->findAll()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if($picture){
                $pictureFileName = $fileUploader->upload($picture);
                $musicGroup->setPicture($pictureFileName);
            }
            $musicGroupRepository->save($musicGroup, true);

            return $this->redirectToRoute('app_music_group_show', ["id" => $musicGroup->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('music_group/new.html.twig', [
            'music_group' => $musicGroup,
            'form' => $form,
        ]);
    }

    #[Route('/favory/add/{id}', name: 'app_music_group_add_favorite', methods: ['GET'])]
    public function addToFavorite(MusicGroup $musicGroup, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $user->addLikedMusicGroup($musicGroup);
        $userRepository->save($user, true);
        return $this->render('music_group/show.html.twig', [
            'music_group' => $musicGroup,
        ]);
    }

    #[Route('/favory/remove/{id}', name: 'app_music_group_remove_favorite', methods: ['GET'])]
    public function removeFromFavorite(MusicGroup $musicGroup, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $user->removeLikedMusicGroup($musicGroup);
        $userRepository->save($user, true);
        return $this->render('music_group/show.html.twig', [
            'music_group' => $musicGroup,
        ]);
    }

    #[Route('/{id}', name: 'app_music_group_show', methods: ['GET'])]
    public function show(MusicGroup $musicGroup): Response
    {
        return $this->render('music_group/show.html.twig', [
            'music_group' => $musicGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_music_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MusicGroup $musicGroup, MusicGroupRepository $musicGroupRepository, TagRepository $tagRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(MusicGroupType::class, $musicGroup, [
            "tags" => $tagRepository->findAll()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if($picture){
                $pictureFileName = $fileUploader->upload($picture);
                $musicGroup->setPicture($pictureFileName);
            }
            $musicGroupRepository->save($musicGroup, true);

            return $this->redirectToRoute('app_music_group_show', ["id" => $musicGroup->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('music_group/edit.html.twig', [
            'music_group' => $musicGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_music_group_delete', methods: ['POST'])]
    public function delete(Request $request, MusicGroup $musicGroup, MusicGroupRepository $musicGroupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musicGroup->getId(), $request->request->get('_token'))) {
            $musicGroupRepository->remove($musicGroup, true);
        }

        return $this->redirectToRoute('app_music_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
