<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Model\UserModelInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory implements UserFactoryInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function createUser(UserModelInterface $userModel): User
    {
        $user = new User();

        return $user
            ->setUsername($userModel->getUsername())
            ->setPassword($this->encoder->encodePassword($user, $userModel->getPassword()));
    }
}
