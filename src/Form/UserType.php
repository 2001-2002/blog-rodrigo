<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, [
                "label" => "Primeiro Nome"
            ])
            ->add('lastName', null, [
                "label" => "Ultimo Nome"
            ])
            ->add('email', null, [
                "label" => "E-mail"
            ])
            ->add('username', null, [
                "label" => "Usuário"
            ])
            ->add('password', PasswordType::class, [
                "label" => "Senha"
            ])
            ->add('avatar', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
