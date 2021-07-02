<?php

namespace App\Form;

use App\Entity\Externo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExternoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externoMail')
            ->add('externoPass')
            ->add('externoAdmin')
            ->add('externoActivo')
            ->add('perfiles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Externo::class,
        ]);
    }
}
