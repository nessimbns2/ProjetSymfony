<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\BookType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/listbook', name: 'listbook')]
    public function listbook(ManagerRegistry $doctrine): Response
    {
        $booksRepo=$doctrine->getRepository(Book::class);
        $books=$booksRepo->findAll();

        return $this->render('book/listbook.html.twig',[
            'books' =>$books,
        ]);
        
    }



    #[Route('/addBook', name: 'addBook')]
    public function addauth(ManagerRegistry $doctrine, Request $request):Response
    {
        $author=new Book();
        $form=$this->createForm(BookType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('listbook');
        }
        return $this->render('book/addBook.html.twig',[
            'bookform'=>$form->createView(),
        ]);
    }


    #[Route('/updatebook/{id}', name: 'updatebook')]
    public function updateauth(ManagerRegistry $doctrine, Request $request,$id):Response
    {
        $bookRepo=$doctrine->getRepository(Book::class);
        $book=$bookRepo->find($id);
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('listbook');
        }
        return $this->render('book/updateBook.html.twig',[
            'bookform'=>$form->createView(),
        ]);
    }


    #[Route('/listbook/{id}', name: 'showbookbyid')]
    public function showAuth(ManagerRegistry $doctrine,$id): Response
    {
        $bookRepo=$doctrine->getRepository(Book::class);
        $book=$bookRepo->find($id);

        return $this->render('book/showbook.html.twig',[
            'book' =>$book,
        ]);
    }

    #[Route('/deleteBook/{id}', name: 'deleteBook')]
    public function deleteAuth(ManagerRegistry $doctrine,$id): Response
    {
        $authorRepo=$doctrine->getRepository(Book::class);
        $author=$authorRepo->find($id);
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('listbook');
    }
}
