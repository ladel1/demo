<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Entity\Produit;
use App\Form\BookType;
use App\Form\CommentType;
use App\Repository\BookRepository;
use App\Repository\CommentRepository;
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
        // creation de l'objet 
        $book = new Book();
        
        // creation formulaire
        $formBook = $this->createForm(BookType::class,$book);
        // ajout de données
        $formBook->handleRequest($request);
        if($formBook->isSubmitted() && $formBook->isValid() ){ 
            $em->persist($book);
            $em->flush();
            $this->addFlash("success","Livre créé");
            return $this->redirectToRoute('app_resultat');
        }
        return $this->render("main/index.html.twig",[
            'formBook'=>$formBook->createView()
        ]);
    }

    /**
     * @Route("/resultat", name="app_resultat")
     */
    public function res(BookRepository $bookRepo,Request $request):Response
    {   
        return $this->render("main/resultat.html.twig");
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


    /**
     * @Route("/detail/{id}", name="app_detail_book")
     */
    public function detail(BookRepository $bookRepo,CommentRepository $commentRepo,Request $request,$id):Response
    {   // recup livre
        $book = $bookRepo->find($id);
        // creation objet comment
        $comment = new Comment();
        // création formulaire
        $commentForm = $this->createForm(CommentType::class,$comment);
        $commentForm->handleRequest($request);
        if($commentForm->isSubmitted()){
            $comment->setBook($book);
            $comment->setDateCreated(new \DateTime("now"));
            $commentRepo->add($comment);
        }

        return $this->render("main/detail.html.twig",["book"=>$book,
        "commentForm"=>$commentForm->createView()]);
    }


}
