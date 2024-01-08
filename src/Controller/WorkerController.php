<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Form\WorkerType;
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
//        return $this->render('worker/new.html.twig', [
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
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // You need to configure this parameter
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // Update the 'image' property to store the image file name
                $worker->setImage($newFilename);
            }

            $entityManager->persist($worker);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('worker/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
