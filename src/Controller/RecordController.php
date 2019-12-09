<?php

namespace App\Controller;

use App\Entity\Record;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/record", name="record_")
 */
class RecordController extends AbstractController
{
    /**
     * Exemple: /record/42
     * @Route("/{id}", name="page")
     */
    public function index(Record $record)
    {
        return $this->render('record/record_page.html.twig', [
            'record' => $record
        ]);
    }
}