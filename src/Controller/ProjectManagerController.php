<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ProjectManagerController extends AbstractController
{
    #[Route('/new-tickets', name: 'new-tickets')]
    public function index()
    {
        $notifications = [
            [
                'title' => 'Drone signal issue',
                'project' => 'DJI Mavic 3 Recon Drone',
                'deadline' => 'Less than 24h'
            ],
            [
                'title' => 'Battery overheating',
                'project' => 'Baba Yaga Bomber Drone',
                'deadline' => 'Immetiately'
            ]
        ];

        return $this->render('project_manager/index.html.twig', [
            'notifications' => $notifications
        ]);
    }

    #[Route('/ticket', name: 'ticket')]
    public function ticket()
    {
        return $this->render('project_manager/ticket.html.twig');
    }
}