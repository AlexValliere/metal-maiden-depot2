<?php

namespace App\Form;

use App\Entity\AttireCategory;
use App\Entity\MetalMaiden;
use App\Entity\Nation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
                'empty_data'  => null,
                'required' => false,
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $metalMaiden = $event->getData();
            $form = $event->getForm();

            // checks if the MetalMaiden object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "MetalMaiden"
            if (!$metalMaiden || null === $metalMaiden->getId()) {
                $form->remove('portraitImageFile'); // Prevent error with filename not yet existing
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MetalMaiden::class,
        ]);
    }
}
