<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Artiste',
                'attr' => [
                    'placeholder' => 'Saisissez le titre de l\'artiste'
                ]
            ])
            ->add('picture_src', FileType::class, [
                'required' => false,
                'label' => 'Photo de l\'oeuvre',
                'attr' => [
                    'onChange' => 'loadFile(event)'
                ]
            ])
            ->add('picture_name', TextType::class, [
                'required' => false,
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Saisissez le nom de l\'oeuvre'
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => false,
                'label' => 'Prix de l\'oeuvre',
                'attr' => [
                    'placeholder' => 'Saisissez le prix de l\'oeuvre'
                ]
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Dites comment c\'est trop beau la touche du maître toussa'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégories',
                'choice_label' => 'title', // J'ai changé name pour title afin de coller a la bdd, j'ai trouvé seul en lisant les erreurs je suis content
                'multiple' => true,
                'placeholder' => 'Saisissez les catégories en liens avec l\'oeuvre',
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-3 btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
