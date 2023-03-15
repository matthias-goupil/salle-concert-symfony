<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Entity\ConcertHall;
use App\Form\ConcertType;
use App\Repository\ConcertHallRepository;
use App\Repository\ConcertRepository;
use App\Repository\MusicGroupRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/concert')]
class ConcertController extends AbstractController
{
    #[Route('/', name: 'app_concert_index', methods: ['GET'])]
    public function index(ConcertRepository $concertRepository): Response
    {
        return $this->render('concert/index.html.twig', [
            'concerts' => $concertRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_concert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConcertRepository $concertRepository, MusicGroupRepository $musicGroupRepository, ConcertHallRepository $concertHallRepository): Response
    {
        $concert = new Concert();
        $form = $this->createForm(ConcertType::class, $concert, [
            "musicGroups" => $musicGroupRepository->findAll(),
            "concertHalls" => $concertHallRepository->findAll()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concert->setMusicGroup($musicGroupRepository->find($form->get('musicGroup')->getData()));
            $concert->setConcertHall($concertHallRepository->find($form->get('concertHall')->getData()));
            $concertRepository->save($concert, true);

            return $this->redirectToRoute('app_concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('concert/new.html.twig', [
            'concert' => $concert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_concert_show', methods: ['GET'])]
    public function show(Concert $concert): Response
    {
        return $this->render('concert/show.html.twig', [
            'concert' => $concert,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_concert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Concert $concert, ConcertRepository $concertRepository, MusicGroupRepository $musicGroupRepository, ConcertHallRepository $concertHallRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ConcertType::class, $concert, [
            "musicGroups" => $musicGroupRepository->findAll(),
            "concertHalls" => $concertHallRepository->findAll()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if($picture){
                $pictureFileName = $fileUploader->upload($picture);
                $concert->setPicture($pictureFileName);
            }
            $concert->setMusicGroup($musicGroupRepository->find($form->get('musicGroup')->getData()));
            $concert->setConcertHall($concertHallRepository->find($form->get('concertHall')->getData()));

            $concertRepository->save($concert, true);

            return $this->redirectToRoute('app_concert_show', ["id" => $concert->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('concert/edit.html.twig', [
            'concert' => $concert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_concert_delete', methods: ['POST'])]
    public function delete(Request $request, Concert $concert, ConcertRepository $concertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concert->getId(), $request->request->get('_token'))) {
            $concertRepository->remove($concert, true);
        }

        return $this->redirectToRoute('app_concert_index', [], Response::HTTP_SEE_OTHER);
    }
}
