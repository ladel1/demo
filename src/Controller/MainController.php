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
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager();
        $book = new Book();
        $book->setTitle("The wolf of wall street")
             ->setAuthor("YYYY")
             ->setPages("231")
             ->setDatePublished(new \DateTime('NOW')); 
             
        $em->persist($book);
        $em->flush();


        dd("salut");
    }
}
