<?php

namespace App\Form;

use App\Entity\Post;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tittle', null, [
                "label" => "Título"
            ])
            ->add('description', null, [
                "label" => "Descrição"
            ])
            ->add('content', null, [
                "label" => "Conteúdo"
            ])
            ->add('slug')
            ->add('status', null, [
                "label" => "Ativo"
            ])
            ->add('categoryCollection')

            ->add('image', FileType::class, [
                'label' => 'Imagem',
                'data_class' => null
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
