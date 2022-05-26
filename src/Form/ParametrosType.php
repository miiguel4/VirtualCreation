<?php

namespace App\Form;

use App\Entity\Parametros;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ParametrosType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('Datastore', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-control bg-light shadow-sm'],
                'choices'  => [
                    'datastore1' => 'datastore1',
                ],
            ])
            
            ->add('CPU',  IntegerType::class, [
                'label' => 'CPU',
                'attr' => ['class' => 'form-control bg-light shadow-sm'],
            ])
            ->add('Memoria',  IntegerType::class, [
                'label' => 'Memoria',
                'attr' => ['class' => 'form-control bg-light shadow-sm'],
            ])
            ->add('SistemaOperativo',  ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-control bg-light shadow-sm'],
                'choices'  => [
                    'Windows' =>  'windows9Server64Guest',
                    'Ubuntu'  =>  'ubuntu64Guest',
                    'Debian'  =>  'otherLinux64Guest',
	
                ],
            ])
            ->add('Nombre',  TextType::class, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control bg-light shadow-sm'],
            ])
            ->add('AdaptadorRed',  ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-control bg-light shadow-sm'],
                'choices'  => [
                    'VM Network' => 'VM Network',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Parametros::class,
        ]);
    }
}
