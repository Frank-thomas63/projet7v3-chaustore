<?php

namespace App\Controller;

use App\Controller\ProductController;
use App\Entity\Product;
use App\Entity\Color;
use App\Repository\ProductRepository;
use App\Repository\ColorRepository;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class ProductController extends AbstractController
{
  /**
   * @var ProductRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;

    public function __construct(productRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/product", name="product.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $products = $this->repository->findAll();
       return $this->render('product/index.html.twig', ['products' => $products]);
    }

// Adds product
  /**
   * @Route("/product/create", name="product.new")
   */

    public function new(Request $request){
      $product = new product();
      $form = $this->createForm(ProductType::class, $product);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->persist($product);
          $this->em->flush();
          $this->addFlash('success', 'product well added successfully');
          return $this->redirectToRoute('product.index');
      }

      return $this->render('product/new.html.twig', [
        'product' => $product,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/product/{id}", name="product.edit", methods="GET|POST")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(product $product, Request $request)
    {

        $form = $this->createForm(productType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'product well edit successfully');
            return $this->redirectToRoute('product.index');
        }

        return $this->render('product/edit.html.twig', [
          'product' => $product,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/product/{id}", name="product.delete", methods="DELETE")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(product $product, Request $request)
    {
      if($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token')))
      {
        $this->em->remove($product);
        $this->em->flush();
        $this->addFlash('success', 'product well delete successfully');
        return $this->redirectToRoute('product.index');
      }


    }
}
