<?php

namespace App\Controller;


use App\Controller\Admin\AdminProductController;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;


class ChaustoreController extends AbstractController
{
    /**
   * @var ProductRepository
   * @var StockRepository
   */
  private $repository;

  /**
   * @var ObjectManager
   */
   private $em;


  public function __construct( productRepository $repository, ObjectManager $em)
  {
      $this->repository = $repository;
      $this->em = $em;
  }


// to display the data >  pour afficher les données
  /**
   * @Route("/", name="chaustore")
   * @return \Symfony\Component\HttpFoundation\Response
   */

  public function index(): Response
  {
     $products = $this->repository->findAll();

     return $this->render('chaustore/index.html.twig', ['products' => $products]);
  }

 

}
