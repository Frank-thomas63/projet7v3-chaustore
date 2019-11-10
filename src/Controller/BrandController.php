<?php

namespace App\Controller;

use App\Controller\BrandController;
use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Form\BrandType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class BrandController extends AbstractController
{
  /**
   * @var BrandRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;

    public function __construct(BrandRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/brand", name="brand.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $brands = $this->repository->findAll();
       return $this->render('brand/index.html.twig', ['brands' => $brands]);
    }

// Adds Brand
  /**
   * @Route("/brand/create", name="brand.new")
   */

    public function new(Request $request){
      $brand = new brand();
      $form = $this->createForm(BrandType::class, $brand);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->persist($brand);
          $this->em->flush();
          $this->addFlash('success', 'brand well added successfully');
          return $this->redirectToRoute('brand.index');
      }

      return $this->render('brand/new.html.twig', [
        'brand' => $brand,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/brand/{id}", name="brand.edit", methods="GET|POST")
     * @param Brand $brand
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(Brand $brand, Request $request)
    {

        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'mark well edit successfully');
            return $this->redirectToRoute('brand.index');
        }

        return $this->render('brand/edit.html.twig', [
          'brand' => $brand,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/brand/{id}", name="brand.delete", methods="DELETE")
     * @param Brand $brand
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Brand $brand, Request $request)
    {
      if($this->isCsrfTokenValid('delete' . $brand->getId(), $request->get('_token')))
      {
        $this->em->remove($brand);
        $this->em->flush();
        $this->addFlash('success', 'mark well delete successfully');
        return $this->redirectToRoute('brand.index');
      }


    }
}
