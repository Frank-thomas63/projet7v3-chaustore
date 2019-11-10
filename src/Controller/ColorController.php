<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ColorController extends AbstractController
{
    /**
     * @Route("/color", name="color")
     */
    public function index()
    {
    
        // $brand = new brand();
        // $brand ->setName('red');
        //
        // $product = new product();
        // $product ->getId(1);
        //
        // $stock = new stock();
        // $stock ->getProduct(1);
        //
        // $em = $this ->getDoctrine()->getManager();
        // $em -> persist($brand);
        // $em -> flush();


        $properties = $this->repository->findAll();

        return $this->render('color/index.html.twig', compact('properties'),[
            'controller_name' => 'Color'
        ]);


    }
}
