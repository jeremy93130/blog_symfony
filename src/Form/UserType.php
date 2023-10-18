<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le pseudonyme est requis !']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Le pseudonyme doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le pseudonyme ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('firstname', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom est requis.']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('lastname', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom est requis.']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'email est requis.']),
                    new Assert\Email(['message' => 'L\'email n\'est pas valide.']),
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Entrez votre mot de passe',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\EqualTo(propertyPath: 'password', message: 'Les deux mots de passe doivent être identiques')
                ],
            ])
            ->add('passwordConfirm', PasswordType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Entrez votre mot de passe',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('send', SubmitType::class)
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}