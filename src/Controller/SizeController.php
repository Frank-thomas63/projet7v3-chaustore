<?php

namespace App\Controller;

use App\Controller\SizeController;
use App\Entity\Size;
use App\Repository\SizeRepository;
use App\Form\SizeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class SizeController extends AbstractController
{
  /**
   * @var SizeRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;

    public function __construct(SizeRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/size", name="size.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $sizes = $this->repository->findAll();
       return $this->render('size/index.html.twig', ['sizes' => $sizes]);
    }

// Adds size
  /**
   * @Route("/size/create", name="size.new")
   */

    public function new(Request $request){
      $size = new size();
      $form = $this->createForm(SizeType::class, $size);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->persist($size);
          $this->em->flush();
          $this->addFlash('success', 'size well added successfully');
          return $this->redirectToRoute('size.index');
      }

      return $this->render('size/new.html.twig', [
        'size' => $size,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/size/{id}", name="size.edit", methods="GET|POST")
     * @param Size $size
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(size $size, Request $request)
    {

        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'size well edit successfully');
            return $this->redirectToRoute('size.index');
        }

        return $this->render('size/edit.html.twig', [
          'size' => $size,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/size/{id}", name="size.delete", methods="DELETE")
     * @param Size $size
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(size $size, Request $request)
    {
      if($this->isCsrfTokenValid('delete' . $size->getId(), $request->get('_token')))
      {
        $this->em->remove($size);
        $this->em->flush();
        $this->addFlash('success', 'size well delete successfully');
        return $this->redirectToRoute('size.index');
      }


    }
}
