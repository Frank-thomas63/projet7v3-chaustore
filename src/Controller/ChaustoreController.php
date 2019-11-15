<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChaustoreController extends AbstractController
{
    /**
     * @Route("/", name="chaustore")
     */
    public function index()
    {
        return $this->render('chaustore/index.html.twig', [
            'controller_name' => 'ChaustoreController',
        ]);
    }
}
