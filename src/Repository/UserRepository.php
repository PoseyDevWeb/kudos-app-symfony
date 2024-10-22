<?php
    
    
    namespace App\Repository;
    
    use App\Entity\User;
    use Doctrine\ORM\EntityRepository;
    
    class UserRepository extends EntityRepository
    {
       
        
        /**
         * Recherche un utilisateur par son adresse e-mail.
         */
        public function findByEmail(string $email): ?User
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();
        }
        
        /**
         * Recherche des utilisateurs dont le nom contient la chaîne donnée.
         */
        public function findByName(string $name): array
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.name LIKE :name')
                ->setParameter('name', '%' . $name . '%')
                ->orderBy('u.name', 'ASC')
                ->getQuery()
                ->getResult();
        }
        
        /**
         * Exemple de méthode personnalisée pour récupérer les utilisateurs avec des rôles spécifiques.
         */
        public function findByRole(string $role): array
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.roles LIKE :role')
                ->setParameter('role', '%' . $role . '%')
                ->getQuery()
                ->getResult();
        }
    }

