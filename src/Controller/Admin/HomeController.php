<?php


namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{

    /**
    * @Route("/admin", name="admin.home")
    */


    public function index()
    {
      return $this->render('admin/home.html.twig');
    }

}
