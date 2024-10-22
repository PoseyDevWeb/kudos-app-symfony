<?php
    
    
    namespace App\Repository;
    
    use App\Entity\Message;
    use Doctrine\ORM\EntityRepository;
    
    class MessageRepository extends EntityRepository
    {
        public function findById(int $id): ?Message
        {
              return $this->find($id);
        }
        public function findAllMessagesAllUsers(): array
        {
            return $this->findAll();
        }
        
        
        
        /**
         * Recherche tous les messages envoyés par un utilisateur donné.
         */
        public function findBySender($userId): array
        {
            return $this->createQueryBuilder('m')
                ->andWhere('m.fromEmployee = :userId')
                ->setParameter('userId', $userId)
                ->orderBy('m.createdAt', 'DESC') // Tri des messages par date
                ->getQuery()
                ->getResult();
        }
        
        /**
         * Recherche tous les messages reçus par un utilisateur donné.
         */
        public function findByReceiver($userId): array
        {
            return $this->createQueryBuilder('m')
                ->andWhere('m.toEmployee = :userId')
                ->setParameter('userId', $userId)
                ->orderBy('m.createdAt', 'DESC') // Tri des messages par date
                ->getQuery()
                ->getResult();
        }
        
        /**
         * Exemple de méthode pour rechercher des messages par mot-clé dans le contenu.
         */
        public function findByKeyword(string $keyword): array
        {
            return $this->createQueryBuilder('m')
                ->andWhere('m.content LIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%')
                ->orderBy('m.createdAt', 'DESC') // Tri des messages par date
                ->getQuery()
                ->getResult();
        }
    }
