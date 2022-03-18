<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,["label"=>"Titre"])
            ->add('author',TextType::class,["label"=>"Auteur"])
            ->add('pages',NumberType::class,["label"=>"Pages"])
            ->add('datePublished',DateType::class,["label"=>"Date de création"])   
            ->add("Ajouter",SubmitType::class,["label"=>"Ajouter un livre"])
            ->add("Effacer",ResetType::class)      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'csrf_message'=>"Le jeton CSRF n'est pas Valide!"
        ]);
    }
}
