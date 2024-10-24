<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }


    #[Route('/showauthor/{name}', name: 'showAuth')]
    public function showAuthor($name): Response
    {
        return $this->render('author/showAuthor.html.twig', [
            "authname"  => $name
        ]);
    }


    #[Route('/listAuthor', name: 'listAuthor')]
    public function listAuthors(): Response
    {   $authors=array(
        array("id"=>"AAAA", "name"=>"ADA", "nbBooks"=>10),
        array("id"=>"BBBB", "name"=>"BDA" ,"nbBooks"=>10 ),
        array("id"=>"CCCC","name"=>"CDA", "nbBooks"=>10),
    );
        return $this->render('author/listAuth.html.twig', [
                'authors'=>$authors
        ]);
    }

    #[Route('/listauthor2', name: 'listAuth2')]
    public function listAuthor2(ManagerRegistry $doctrine): Response
    {
        $authorsRepo=$doctrine->getRepository(Author::class);
        $authors=$authorsRepo->findAll();

        return $this->render('author/listAuth2.html.twig',[
            'authors' =>$authors,
        ]);
        
    }

    #[Route('/listauthor3/{id}', name: 'showauthbyid')]
    public function showAuth(ManagerRegistry $doctrine,$id): Response
    {
        $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);

        return $this->render('author/listAuth3.html.twig',[
            'author' =>$author,
        ]);
    }

    #[Route('/deleteAuth/{id}', name: 'deleteAuth')]
    public function deleteAuth(ManagerRegistry $doctrine,$id): Response
    {
        $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('listAuth2');
    }

    #[Route('/addauth', name: 'addauth')]
    public function addauth(ManagerRegistry $doctrine, Request $request):Response
    {
        $author=new Author();
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('listAuth2');
        }
        return $this->render('author/addAuthor.html.twig',[
            'authform'=>$form->createView(),
        ]);
    }

    #[Route('/listauthorSorted', name: 'listAuthorSorted')]
    public function listAuthorSorted(AuthorRepository $authorsRepo): Response
    {
        $authors=$authorsRepo->findAuthorOrderByMail();

        return $this->render('author/listAuth2.html.twig',[
            'authors' =>$authors,
        ]);
        
    }    

    #[Route('/updateauth/{id}', name: 'updateauth')]
    public function updateauth(ManagerRegistry $doctrine, Request $request,$id):Response
    {
        $authorRepo=$doctrine->getRepository(Author::class);
        $author=$authorRepo->find($id);
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('listAuth2');
        }
        return $this->render('author/updateauth.html.twig',[
            'authform'=>$form->createView(),
        ]);
    }


}
