<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\RecordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RecordRepository $recordRepository)
    {
        // Récupération du top 100
        $top = $recordRepository->getBestRatedOfYear();

        return $this->render('index.html.twig', [
            'top' => $top,
        ]);
    }
}
