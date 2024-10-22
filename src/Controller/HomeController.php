<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
    #[Route('/home',name:'home')]
  public function Home(){
    return new Response('<html><body><h1>Hello World</h1></body></html>');
  }
}

?>