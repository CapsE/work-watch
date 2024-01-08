<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/project/new', name: 'project_new')]
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the worker to the database
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            // Redirect to '/' (homepage)
            return $this->redirectToRoute('home');
        }

        return $this->render('project/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/project/edit/{id}', name: 'project_edit')]
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the worker to the database
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            // Redirect to '/' (homepage)
            return $this->redirectToRoute('home');
        }

        return $this->render('project/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/project/list', name: 'project_list')]
    public function list(Request $request, ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('project/list.html.twig', [
            'projects' => $projects,
        ]);
    }
}
