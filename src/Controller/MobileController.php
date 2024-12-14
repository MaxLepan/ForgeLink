<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MobileController extends AbstractController
{
    #[Route('/mobile', name: 'mobile')]
    public function index()
    {
        return $this->render('mobile/index.html.twig');
    }

    #[Route('/mobile-inline', name: 'mobile-inline')]
    public function index2()
    {
        return $this->render('mobile/index2.html.twig');
    }
}