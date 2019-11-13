<?php

namespace App\Controller;

use App\Controller\CategoryController;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryController extends AbstractController
{
  /**
   * @var CategoryRepository
   */
    private $repository;

    /**
     * @var ObjectManager
     */
     private $em;

    public function __construct(CategoryRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


// to display the data >  pour afficher les données
    /**
     * @Route("/category", name="category.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
       $categorys = $this->repository->findAll();
       return $this->render('category/index.html.twig', ['categorys' => $categorys]);
    }

// Adds Category
  /**
   * @Route("/category/create", name="category.new")
   */

    public function new(Request $request){
      $category = new category();
      $form = $this->createForm(CategoryType::class, $category);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->persist($category);
          $this->em->flush();
          $this->addFlash('success', 'Category well added successfully');
          return $this->redirectToRoute('category.index');
      }

      return $this->render('category/new.html.twig', [
        'category' => $category,
        'form' => $form->createView()
      ]);
    }


// page edit
    /**
     * @Route("/category/{id}", name="category.edit", methods="GET|POST")
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(Category $category, Request $request)
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Category well edit successfully');
            return $this->redirectToRoute('category.index');
        }

        return $this->render('category/edit.html.twig', [
          'category' => $category,
          'form' => $form->createView()
        ]);
    }
// page delete
    /**
     * @Route("/category/{id}", name="category.delete", methods="DELETE")
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Category $category, Request $request)
    {
      if($this->isCsrfTokenValid('delete' . $category->getId(), $request->get('_token')))
      {
        $this->em->remove($category);
        $this->em->flush();
        $this->addFlash('success', 'Category well delete successfully');
        return $this->redirectToRoute('category.index');
      }


    }
}
