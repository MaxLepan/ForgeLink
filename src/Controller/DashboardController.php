<?php

namespace App\Controller;

use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard', name: 'app_dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FeedbackRepository $feedbackRepository): Response
    {
        $lastFeedbacks = $feedbackRepository->findLastNewFeedbacks();

        return $this->render('dashboard/index.html.twig', [
            'last_feedbacks' => $lastFeedbacks
        ]);
    }
}
