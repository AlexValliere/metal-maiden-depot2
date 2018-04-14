<?php

namespace App\Form;

use App\Entity\AttireCategory;
use App\Entity\MetalMaiden;
use App\Entity\Nation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetalMaidenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('attire')
            ->add('attire_category', EntityType::class, array(
                'class' => AttireCategory::class,
                'choice_label' => 'name',
                'multiple'     => false,
            ))
            ->add('portraitImageFile', FileType::class, array(
                'required'    => false
            ))
            ->add('nation', EntityType::class, array(
                'class' => Nation::class,
                'choice_label' => 'name',
                'multiple'     => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MetalMaiden::class,
        ]);
    }
}
