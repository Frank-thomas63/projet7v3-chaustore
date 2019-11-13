<?php

namespace App\Controller;

use App\Controller\StockController;
use App\Entity\Stock;
use App\Repository\StockRepository;
use App\Form\StockType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class StockController extends AbstractController
{
  /**
   * @var stockRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;

    public function __construct(stockRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/stock", name="stock.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $stocks = $this->repository->findAll();
       return $this->render('stock/index.html.twig', ['stocks' => $stocks]);
    }

// Adds stock
  /**
   * @Route("/stock/create", name="stock.new")
   */

    public function new(Request $request){
      $stock = new stock();
      $form = $this->createForm(StockType::class, $stock);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->persist($stock);
          $this->em->flush();
          $this->addFlash('success', 'stock well added successfully');
          return $this->redirectToRoute('stock.index');
      }

      return $this->render('stock/new.html.twig', [
        'stock' => $stock,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/stock/{id}", name="stock.edit", methods="GET|POST")
     * @param Stock $stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(stock $stock, Request $request)
    {

        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'stock well edit successfully');
            return $this->redirectToRoute('stock.index');
        }

        return $this->render('stock/edit.html.twig', [
          'stock' => $stock,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/stock/{id}", name="stock.delete", methods="DELETE")
     * @param Stock $stock
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(stock $stock, Request $request)
    {
      if($this->isCsrfTokenValid('delete' . $stock->getId(), $request->get('_token')))
      {
        $this->em->remove($stock);
        $this->em->flush();
        $this->addFlash('success', 'stock well delete successfully');
        return $this->redirectToRoute('stock.index');
      }


    }
}
