<?php

namespace App\Form;

use App\Entity\Externo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ExternoEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externoMail', EmailType::class, [
                'required' => true,
                'label' => 'Correo Electronico',
                'attr' => array(
                    'placeholder' => 'Ingrese su Correo'
                )
            ])
            ->add('externoPass', PasswordType::class, [
                'required' => true,
                'label' => 'Password',
                'attr' => array(
                    'placeholder' => 'Ingrese su Contraseña'
                )
            ])
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
