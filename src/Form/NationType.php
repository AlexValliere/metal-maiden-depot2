<?php

namespace App\Form;

use App\Entity\Nation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('imageFile', FileType::class, array(
                'required'    => false
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $nation = $event->getData();
            $form = $event->getForm();

            // checks if the nation object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "nation"
            if (!$nation || null === $nation->getId()) {
                $form->remove('imageFile'); // Prevent error with filename not yet existing
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nation::class,
        ]);
    }
}
