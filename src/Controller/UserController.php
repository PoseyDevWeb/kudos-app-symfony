<?php

    namespace App\Controller;
    
    use App\Entity\Message;
    use App\Entity\User;
    use App\Form\UserType;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\File\Exception\FileException;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\String\Slugger\SluggerInterface;
    
    class UserController extends AbstractController
    {
        private $entityManager;
           
           public function __construct(EntityManagerInterface $entityManager)
           {
               $this->entityManager = $entityManager;
           }
           
           
        #[Route('/users', name: 'user_index')]
        public function index(): Response
        {
            
            $users = $this->entityManager->getRepository(User::class)->findAll();
            return $this->render('user/index.html.twig', [
                'users' => $users,
            ]);
        }
    
        #[Route('/user/new', name: 'user_new')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gére le téléchargement de l'avatar
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Cela est nécessaire pour inclure un nom unique dans le fichier
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

                // Déplace le fichier dans le répertoire où les avatars sont stockés
                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'), // Assurez-vous que ce paramètre est défini dans services.yaml
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gére l'exception si quelque chose ne va pas lors du déplacement du fichier
                }

                // Met à jour la propriété 'avatar' de l'utilisateur avec le nouveau nom de fichier
                $user->setAvatar($newFilename);
            }

            // Encrypter le mot de passe avant de le persister (à ajuster si tu utilises un autre système d'encodage)
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
        #[Route('/user/{id}/messages', name: 'user_messages')]
        public function showUserMessages(int $id, EntityManagerInterface $em): Response
        {
            $user = $this->entityManager->getRepository(User::class)->find($id);
            
            $sentMessages = $em->getRepository(Message::class)->findBy(['fromEmployee' => $user]);
            
            $receivedMessages = $em->getRepository(Message::class)->findBy(['toEmployee' => $user]);
        
            return $this->render('user/messages.html.twig', [
                'user' => $user,
                'sentMessages' => $sentMessages,
                'receivedMessages' => $receivedMessages,
            ]);
        }
    
        #[Route('/user/{id}', name: 'user_show')]
        public function show(int $id): Response
        {
            $user = $this->entityManager->getRepository(User::class)->find($id);
            
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        }
    
       
    }

