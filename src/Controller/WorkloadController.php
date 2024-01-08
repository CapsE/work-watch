<?php

namespace App\Controller;

use App\Entity\Workload;
use App\Form\WorkloadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkloadController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/workload/new', name: 'workload_new')]
    public function new(Request $request): Response
    {
        $workload = new Workload();
        $form = $this->createForm(WorkloadType::class, $workload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the worker to the database
            $this->entityManager->persist($workload);
            $this->entityManager->flush();

            // Redirect to '/' (homepage)
            return $this->redirectToRoute('home');
        }

        return $this->render('workload/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
