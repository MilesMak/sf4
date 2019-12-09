<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/label", name="label_")
 */
class LabelController extends AbstractController
{
    /**
     * @Route("/{id}", name="page")
     */
    public function index($id, LabelRepository $labelRepository)
    {
        $label = $labelRepository->find($id);

        return $this->render('label/label_page.html.twig', [
            'label' => $label
        ]);
    }
}
