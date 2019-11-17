<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminColorController;
use App\Entity\Color;
use App\Repository\ColorRepository;
use App\Form\ColorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class ColorController extends AbstractController
{
  /**
   * @var ColorRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;

    public function __construct(colorRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/admin/color", name="admin.color.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $colors = $this->repository->findAll();
       return $this->render('admin/color/index.html.twig', ['colors' => $colors]);
    }

// Adds color
  /**
   * @Route("/admin/color/create", name="admin.color.new")
   */

    public function new(Request $request){
      $color = new color();
      $form = $this->createForm(ColorType::class, $color);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->persist($color);
          $this->em->flush();
          $this->addFlash('success', 'color well added successfully');
          return $this->redirectToRoute('admin.color.index');
      }

      return $this->render('admin/color/new.html.twig', [
        'color' => $color,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/admin/color/{id}", name="admin.color.edit", methods="GET|POST")
     * @param Color $color
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(color $color, Request $request)
    {

        $form = $this->createForm(ColorType::class, $color);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'color well edit successfully');
            return $this->redirectToRoute('admin.color.index');
        }
        return $this->render('admin/color/edit.html.twig', [
          'color' => $color,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/admin/color/{id}", name="admin.color.delete", methods="DELETE")
     * @param Color $color
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(color $color, Request $request)
    {
      if($this->isCsrfTokenValid('delete' . $color->getId(), $request->get('_token')))
      {
        $this->em->remove($color);
        $this->em->flush();
        $this->addFlash('success', 'admin/color well delete successfully');
        return $this->redirectToRoute('admin.color.index');
      }


    }
}
