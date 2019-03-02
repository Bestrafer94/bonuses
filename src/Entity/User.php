<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Email()
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserProfile", cascade={"remove"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RealMoneyWallet", cascade={"remove"})
     * @ORM\JoinColumn(name="real_money_wallet_id", referencedColumnName="id")
     *
     * @var RealMoneyWallet
     */
    private $realMoneyWallet;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\BonusMoneyWallet")
     * @ORM\JoinTable(name="users_bonus_money_wallets",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="bonus_money_wallets_id", referencedColumnName="id", unique=true)}
     * )
     *
     * @var ArrayCollection
     */
    private $bonusMoneyWallets;

    public function __construct()
    {
        $this->bonusMoneyWallets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return UserProfile
     */
    public function getProfile(): UserProfile
    {
        return $this->profile;
    }

    /**
     * @param UserProfile $profile
     *
     * @return User
     */
    public function setProfile(UserProfile $profile): User
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return RealMoneyWallet
     */
    public function getRealMoneyWallet(): RealMoneyWallet
    {
        return $this->realMoneyWallet;
    }

    /**
     * @param RealMoneyWallet $realMoneyWallet
     *
     * @return User
     */
    public function setRealMoneyWallet(RealMoneyWallet $realMoneyWallet): User
    {
        $this->realMoneyWallet = $realMoneyWallet;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBonusMoneyWallets(): ArrayCollection
    {
        return $this->bonusMoneyWallets;
    }

    /**
     * @param BonusMoneyWallet $bonusMoneyWallets
     *
     * @return User
     */
    public function addBonusMoneyWallet(BonusMoneyWallet $bonusMoneyWallets): User
    {
        $this->bonusMoneyWallets[] = $bonusMoneyWallets;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }
}
