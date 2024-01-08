<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Form\WorkerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkerController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/worker/new', name: 'worker_new')]
    public function new(Request $request): Response
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerType::class, $worker);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the worker to the database
            $this->entityManager->persist($worker);
            $this->entityManager->flush();

            // Redirect to '/' (homepage)
            return $this->redirectToRoute('home');
        }

        return $this->render('worker/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
