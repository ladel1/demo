<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="app_main")
     */
    public function index(EntityManagerInterface $em): Response
    {
        // obtenir Manager interface
        // $em = $this->getDoctrine()->getManager();
        // creation de l'objet 
        // $book = new Book();
        // $book->setTitle("The wolf of wall street")
        //      ->setAuthor("YYYY")
        //      ->setPages("231")
        //      ->setDatePublished(new \DateTime('NOW')); 
        // ajout dans bdd     
        // $em->persist($book);
        // $em->flush();
        return $this->render("main/index.html.twig");
    }
}
