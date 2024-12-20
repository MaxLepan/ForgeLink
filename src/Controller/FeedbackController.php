<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Feedback;
use App\Entity\SuperTicket;
use App\Entity\Ticket;
use App\Entity\User;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Enum\TicketTypes;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
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
            'form' => $form,
            'display_sidebar' => false,
        ]);
    }

    #[Route('/feedback/{id}', name: 'feedback_show')]
    public function show($id, FeedbackRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedback = $repository->find($id);

        if (!$feedback) {
            throw $this->createNotFoundException(
                'No feedback found for id ' . $id
            );
        }

        $child_tickets = $feedback->getChildTickets();

        $ticket = new SuperTicket();
        $ticket->setParentFeedback($feedback);
        $ticket->setStatus(TicketStatus::PENDING);

        $form = $this->createFormBuilder($ticket)
            ->add('title', TextType::class)
            ->add('type', EnumType::class, [
                'class' => TicketTypes::class,
            ])
            ->add('priority', EnumType::class, [
                'class' => TicketPriority::class,
            ])
            ->add('description', TextareaType::class)
            ->add('assignee', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    // return all users with the role "lead_developer" or 'lead_engineer' or 'lead_manufacturer'
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role', '%lead_developer%')
                        ->orWhere('u.roles LIKE :role2')
                        ->setParameter('role2', '%lead_engineer%')
                        ->orWhere('u.roles LIKE :role3')
                        ->setParameter('role3', '%lead_manufacturer%');
                },
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName() . ' (' . $user->getRoles()[0]->value . ')';
                },
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Ticket'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();

            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('feedback_show', ['id' => $id]);
        }

        return $this->render('feedback/show.html.twig', [
            'feedback' => $feedback,
            'form' => $form,
            'child_tickets' => $child_tickets,
        ]);
    }
}
