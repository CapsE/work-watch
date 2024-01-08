<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Form\WorkerType;
use App\Repository\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

//    public function new(Request $request): Response
//    {
//        $worker = new Worker();
//        $form = $this->createForm(WorkerType::class, $worker);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            // Save the worker to the database
//            $this->entityManager->persist($worker);
//            $this->entityManager->flush();
//
//            // Redirect to '/' (homepage)
//            return $this->redirectToRoute('home');
//        }
//
//        return $this->render('worker/form.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

    #[Route('/worker/new', name: 'worker_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $worker->setImage($this->handleFileUpload($file));
            }

            $entityManager->persist($worker);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('worker/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/worker/edit/{id}', name: 'worker_edit')]
    public function edit(Request $request, Worker $worker, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $worker->setImage($this->handleFileUpload($file));
            }

            $entityManager->flush();

            return $this->redirectToRoute('worker_list'); // Redirect to the list of workers
        }

        return $this->render('worker/form.html.twig', [
            'worker' => $worker,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/worker/list', name: 'worker_list')]
    public function list(Request $request, WorkerRepository $workerRepository): Response
    {
        $workers = $workerRepository->findAllSortedByName();

        return $this->render('worker/list.html.twig', [
            'workers' => $workers,
        ]);
    }

    private function handleFileUpload($file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        // Move the file to the directory where images are stored
        try {
            $file->move(
                $this->getParameter('images_directory'), // You need to configure this parameter
                $newFilename
            );
        } catch
        (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // Update the 'image' property to store the image file name
        return $newFilename;

    }
}
