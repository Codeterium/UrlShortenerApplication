<?php

namespace App\Form;

use App\Entity\Shorten;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShortenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Url field in form
        $builder
            ->add(
                'url',
                TextType::class,
                [
                    'required'=>false,
                    'label' => false,
                    'attr' => ['placeholder' => 'Enter your link here']
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shorten::class,
        ]);
    }
}
