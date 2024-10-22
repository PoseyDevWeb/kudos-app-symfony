<?php

    namespace App\Form;
    
    use App\Entity\User;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\File;
    
    class UserType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Nom',
                ])
                ->add('email', TextType::class, [
                    'label' => 'Email',
                ])
                ->add('password', PasswordType::class, [
                          'label' => 'Mot de passe',
                      ])
                ->add('avatar', FileType::class, [
                    'label' => 'Avatar (Image file)',
    
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,
    
                    // make it optional so you don't have to re-upload an avatar
                    'required' => false,
    
                    // You can add validation constraints here
                    'constraints' => [
                        new File([
                            'maxSize' => '2M', // Taille max de 2 Mo
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                            ],
                            'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG ou GIF)',
                        ]),
                    ],
                ])
            ;
        }
    
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => User::class, // Associe le formulaire à l'entité User
            ]);
        }
    }



