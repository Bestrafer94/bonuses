<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProfileRepository extends ServiceEntityRepository implements UserProfileRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProfile::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByUser(UserInterface $user): ?UserProfile
    {
        return $this->findOneBy(['user' => $user]);
    }
}
