<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name: 'create_feedback')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedback = new Feedback();

        $form = $this->createFormBuilder($feedback)
            ->add('title', TextType::class)
            ->add('event_date', DateTimeType::class)
            ->add('location', TextType::class)
            ->add('environmental_conditions', TextType::class)
            ->add('operation_type', TextType::class)
            ->add('description', TextareaType::class)
            ->add('deadline', TextType::class)
            ->add('suggested_solution', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Feedback'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $form->getData();

            $entityManager->persist($feedback);
            $entityManager->flush();

            return $this->redirectToRoute('password');
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/feedback/{id}', name: 'feedback_show')]
    public function show($id, FeedbackRepository $repository): Response
    {
        $feedback = $repository->find($id);

        if (!$feedback) {
            throw $this->createNotFoundException(
                'No feedback found for id ' . $id
            );
        }

        return $this->render('feedback/show.html.twig', [
            'feedback' => $feedback,
            'display_sidebar' => true
        ]);
    }
}
