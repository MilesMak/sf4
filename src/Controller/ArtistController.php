<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\Artist\SearchFormType;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artist", name="artist_")
 */
class ArtistController extends AbstractController
{
    /**
     * URI: /artist-list
     * Nom: artist_list
     * @Route("-list", name="list")
     */
    public function index(ArtistRepository $artistRepository)
    {
        // Création du formulaire
        $form = $this->createForm(SearchFormType::class);

        return $this->render('artists/list.html.twig', [
            'artist_list' => $artistRepository->findAll(),
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="page")
     */
    public function page(Artist $artist)
    {
        return $this->render('artists/artist_page.html.twig', [
            'artist' => $artist
        ]);
    }
}
