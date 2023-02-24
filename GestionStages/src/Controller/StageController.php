<?php

namespace App\Controller;

use App\Form\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StageRepository;

class StageController extends AbstractController
{
    /**
     * Lister tous les stages.
     * @Route("/stage/", name="stage.list")
     * @return Response
     */
/*    public function list() : Response
    {
        $stages = $this->getDoctrine()->getRepository(Stage::class)->findAll();
        return $this->render('stage/list.html.twig', [
            'stages' => $stages,
        ]);
    }*/

    /**
     * Lister uniquement les stages qui n'on pas encore expiré !
     * @Route("/stage", name="stage.list")
     * @return Response
     */
/*    public function list(EntityManagerInterface $em) : Response
    {
        $query = $em->createQuery(
            'SELECT s FROM App:Stage s WHERE s.date_expiration > :date'
        )->setParameter('date', new \DateTime());
        $stages = $query->getResult();
        return $this->render('stage/list.html.twig', [
            'stages' => $stages,
        ]);
    }*/
    public function list(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->getStagesNonExpires();
        return $this->render('stage/list.html.twig', [
            'stages' => $stages,
        ]);
    }


    /**
     * Chercher et afficher un stage.
     * @Route("/stage/{id}", name="stage.show", requirements={"id" = "\d+"})
     * @param Stage $stage
     * @return Response
     */
    public function show(Stage $stage) : Response
    {
        return $this->render('stage/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * Créer un nouveau stage.
     * @Route("/nouveau-stage", name="stage.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stage);
            $em->flush();
            return $this->redirectToRoute('stage.list');
        }
        return $this->render('stage/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
