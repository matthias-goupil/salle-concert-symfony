<?php

namespace App\Controller;

use App\Entity\ConcertHall;
use App\Repository\ConcertHallRepository;
use App\Repository\ConcertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app', priority: -1)]
    public function index(ConcertRepository $concertRepository, ConcertHallRepository $concertHallRepository): Response
    {

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            "concert_halls" => $concertHallRepository->findAll()
        ]);
    }
}


