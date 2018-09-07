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
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
/*use Symfony\Component\Form\Extension\Core\Type\DateType;*/
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetalMaidenType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', null, array(
				'label_format' => 'label.name',
			))
			->add('attire', null, array(
				'label_format' => 'form.metal_maiden.%name%',
			))
			->add('attire_category', EntityType::class, array(
				'class' => AttireCategory::class,
				'choice_label' => 'name',
				'label_format' => 'form.metal_maiden.%name%',
				'multiple'     => false,
			))
			->add('portraitImageFile', FileType::class, array(
				'required'    => false,
			))
			->add('nation', EntityType::class, array(
				'class' => Nation::class,
				'choice_label'	=> 'name',
				'label_format'	=> 'form.metal_maiden.%name%',
				'multiple'		=> false,
				'empty_data'	=> null,
				'required'		=> false,
			))
			->add('birthdate', BirthdayType::class, array(
				'label_format'	=> 'form.metal_maiden.%name%',
				'years'			=> range(date('1900'), date('Y')),
			))
			->add('height', IntegerType::class, array(
				'label_format'	=> 'form.metal_maiden.%name%',
				'attr'			=> array(
					'min'			=> '20',
					'max'			=> '300',
				),
			))
			->add('bloodType', ChoiceType::class, array(
				'choices'  => array(
					' '		=> null,
					'O'		=> 'O',
					'O+'	=> 'O+',
					'O-'	=> 'O-',
					'A'		=> 'A',
					'A+'	=> 'A+',
					'A-'	=> 'A-',
					'B'		=> 'B',
					'B+'	=> 'B+',
					'B-'	=> 'B-',
					'AB'	=> 'AB',
					'AB+'	=> 'AB+',
					'AB-'	=> 'AB-',
			    ),
			))
			->add('affiliation', TextType::class, array(
				'label_format' => 'form.metal_maiden.%name%',
			))
			->add('occupation', TextType::class, array(
				'label_format' => 'form.metal_maiden.%name%',
			))
			->add('profile', TextareaType::class, array(
				'label_format' => 'form.metal_maiden.%name%',
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
