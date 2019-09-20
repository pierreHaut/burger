<?php

namespace App\Form;

use App\Entity\Burger;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,array( 'label' => 'Nom') )
            ->add('description',TextareaType::class )
            ->add('price', IntegerType::class, array( 'label' => 'Prix'))
            ->add('suppDouble', IntegerType::class, array( 'label' => 'Supplément double'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Burger::class,
        ]);
    }
}
