<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class PasswordController extends AbstractController
{
    #[Route('/password', name: 'password')]
    public function index()
    {
        return $this->render('password/index.html.twig');
    }
}