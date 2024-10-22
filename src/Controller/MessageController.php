<?php

    namespace App\Controller;
    
    use App\Entity\Message; // Changement ici pour utiliser l'entité Message
    use App\Form\MessageType; // Changement ici pour utiliser le formulaire MessageType
    use App\Repository\MessageRepository; // Changement ici pour utiliser le repository MessageRepository
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RequestStack;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Contracts\Translation\TranslatorInterface;
    
    class MessageController extends AbstractController
    {
        private $entityManager;
       
           public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, TranslatorInterface $translator)
           {
               $this->entityManager = $entityManager;
           }
           
           
        #[Route('/message', name: 'message_index')]
        public function index(): Response
        {
            $messages = $this->entityManager->getRepository(Message::class)->findAllMessagesAllUsers();
            return $this->render('message/index.html.twig', [
                'messages' => $messages,
            ]);
        }
    
        #[Route('/message/new', name: 'message_new')]
        public function new(Request $request, EntityManagerInterface $em): Response
        {
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // On récupère les utilisateurs sélectionnés dans le formulaire
                $fromEmployee = $form->get('fromEmployee')->getData();
                $toEmployee = $form->get('toEmployee')->getData();
    
                // Assurez-vous que les méthodes existent dans l'entité Message
                $message->setFromEmployee($fromEmployee);
                $message->setToEmployee($toEmployee);
                $message->setCreatedAt(new \DateTime());
    
                // Sauvegarde du message
                $em->persist($message);
                $em->flush();
    
                // Redirige vers la page d'index des messages après enregistrement
                return $this->redirectToRoute('message_index');
            }
    
            return $this->render('message/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }
            
        
    
        #[Route('/message/{id}/edit', name: 'message_edit')]
        public function edit(Request $request,int $id, EntityManagerInterface $em): Response
        {
            $message = $this->entityManager->getRepository(Message::class)->findById($id);
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return $this->redirectToRoute('message_index');
            }
    
            return $this->render('message/edit.html.twig', [
                'form' => $form->createView(),
                'message' => $message,
            ]);
        }
    
        #[Route('/message/{id}/delete', name: 'message_delete', methods: ['POST'])]
        public function delete(Request $request,int $id, EntityManagerInterface $em): Response
        {
            $message = $this->entityManager->getRepository(Message::class)->findById($id);
            if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
                $em->remove($message);
                $em->flush();
            }
    
            return $this->redirectToRoute('message_index');
        }
        
      
    }

