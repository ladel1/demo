<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auteur", name="app_author_")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(Author $author): Response
    {     
        return $this->render('author/detail.html.twig',["author"=>$author]);
    }

    /**
     * @Route("/ajouter", name="add")
     */
    public function add(Request $request,AuthorRepository $authorRepo): Response
    {
        $author = new Author();
        $authorForm = $this->createForm(AuthorType::class,$author);
        $authorForm->handleRequest($request);
        if($authorForm->isSubmitted() && $authorForm->isValid()){
            $authorRepo->add($author);
            return $this->redirectToRoute("app_author_list");
        }
        return $this->render('author/add.html.twig',[
            "authorForm"=>$authorForm->createView()
        ]);
    }
    
    /**
     * @Route("/liste", name="list")
     */
    public function list(AuthorRepository $authorRepo): Response
    {
        return $this->render('author/list.html.twig',
        ["authors"=>$authorRepo->findAll()]);
    }    
}
