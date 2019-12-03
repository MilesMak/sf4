<?php

namespace App\Controller;

use App\Entity\Artist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em)
    {
        // Création d'une nouvelle instance d'artiste
        $artist = (new Artist())
            ->setName('Aymeric')
            ->setDescription('Pas un vrai artiste...')
        ;

        // INSERT ou UPDATE
        $em->persist($artist);

        // DELETE
        // $em->remove($entity);

        // Exécution des requêtes SQL
        $em->flush();

        return $this->render('index.html.twig');
    }
}
