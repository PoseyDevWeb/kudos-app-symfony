<?php

    namespace App\Form;
    
    use App\Entity\Message;
    use App\Entity\User; // Utilisation de l'entité User pour la liste déroulante
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    
    class MessageType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                // Sélectionner l'employé qui envoie le message
                ->add('fromEmployee', EntityType::class, [
                    'class' => User::class, // Utilise l'entité User pour remplir la liste déroulante
                    'choice_label' => 'name', // Le champ 'name' de l'entité User sera affiché dans la liste
                    'label' => 'Qui envoie le message ?', // Étiquette du champ
                    'placeholder' => 'Sélectionnez un employé', // Placeholder pour la liste déroulante
                ])
                // Sélectionner l'employé à qui le message est envoyé
                ->add('toEmployee', EntityType::class, [
                    'class' => User::class, // Utilise l'entité User pour remplir la liste déroulante
                    'choice_label' => 'name', // Le champ 'name' de l'entité User sera affiché dans la liste
                    'label' => 'À qui souhaitez-vous envoyer le message ?', // Étiquette du champ
                    'placeholder' => 'Sélectionnez un employé', // Placeholder pour la liste déroulante
                ])
                ->add('reason', TextareaType::class, [
                    'label' => 'Votre message', // Étiquette du champ de texte
                ])
                ;
        }
    
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Message::class, // Associe le formulaire à l'entité Message
            ]);
        }
    }
    