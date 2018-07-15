<?php

namespace App\Form;

use App\Entity\AttireCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttireCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('abbreviation', null, array(
                'label_format' => 'form.attire_category.%name%',
            ))
            ->add('name', null, array(
                'label_format' => 'form.attire_category.%name%',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttireCategory::class,
        ]);
    }
}
