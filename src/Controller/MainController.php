<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/ajouter-livre", name="app_main")
     */
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        if($request->getMethod()=="POST"){
            
            $title = $request->request->get("title");
            $author = $request->request->get("author");
            $pages = $request->request->get("pages");
            $date = $request->request->get("date");
        

            // obtenir Manager interface
            // $em = $this->getDoctrine()->getManager();
            // creation de l'objet 
            $book = new Book();
            $book->setTitle($title)
                 ->setAuthor($author)
                 ->setPages($pages)
                 ->setDatePublished(new \DateTime($date)); 
            // ajout dans bdd     
            $em->persist($book);
            $em->flush();
        }

        return $this->render("main/index.html.twig");
    }

    /**
     * @Route("/liste-livres", name="app_list_book")
     */
    public function bookList(BookRepository $bookRepo,Request $request):Response
    {   
        $books = array();

        if( !empty($request->query->get("s"))  ){
            $books = $bookRepo->findBookByTitleQueryBuilder($request->query->get("s"));
        }else{
            $books = $bookRepo->findAll();
        }
        return $this->render("main/book-list.html.twig",compact("books"));
    }


}
