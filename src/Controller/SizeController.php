<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SizeController extends AbstractController
{
    /**
     * @Route("/size", name="size")
     */
    public function index()
    {
        return $this->render('size/index.html.twig', [
            'controller_name' => 'SizeController',
        ]);
    }
}
