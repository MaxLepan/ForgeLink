<?php

namespace App\Repository;

use App\Entity\User;
use App\Enum\UserRoles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function createUser(UserRoles $role): User
    {
        $persistedUsers = $this->findAll();
        if (count($persistedUsers) < 7) {
            $user = new User();
            $user->setEmail('test@mail.com');
            $user->setFirstName('John');
            $user->setLastName('Doe');
            $user->setRoles([$role]);

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return $user;
        } else {
            return $persistedUsers[array_rand($persistedUsers)];
        }
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
