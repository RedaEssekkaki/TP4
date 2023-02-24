<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function list(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->getCategoriesAvecStagesNonExpires();
        return $this->render('categorie/list.html.twig', [
            'categories' => $categories,
        ]);
    }
}
