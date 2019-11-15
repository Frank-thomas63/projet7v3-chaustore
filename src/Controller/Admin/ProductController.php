<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminProductController;
use App\Entity\Product;
use App\Entity\Color;
use App\Entity\Stock;
use App\Repository\ProductRepository;
use App\Repository\ColorRepository;
use App\Repository\StockRepository;
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
   * @var StockRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;


    public function __construct(stockRepository $repositoryStocks, productRepository $repository, ObjectManager $em)
    {
        $this->repositoryStocks =$repositoryStocks;
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/admin/product", name="admin.product.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $stocks= $this->repositoryStocks->findAll();
       $products = $this->repository->findAll();
       return $this->render('admin/product/index.html.twig', ['products' => $products, 'stocks' => $stocks]);
    }

// Adds product
  /**
   * @Route("/admin/product/create", name="admin.product.new")
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
          return $this->redirectToRoute('admin.product.index');
      }

      return $this->render('admin/product/new.html.twig', [
        'product' => $product,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/admin/product/{id}", name="admin.product.edit", methods="GET|POST")
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
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/edit.html.twig', [
          'product' => $product,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/admin/product/{id}", name="admin.product.delete", methods="DELETE")
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
        return $this->redirectToRoute('admin.product.index');
      }
    }
}
