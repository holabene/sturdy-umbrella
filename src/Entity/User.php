<?php
namespace SturdyUmbrella\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package SturdyUmbrella\Entity
 *
 * @ORM\Entity()
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $password;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="User")
     */
    protected $friends;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->friends = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFriends() : Collection
    {
        return $this->friends;
    }

    /**
     * @param User $user
     * @return User
     */
    public function addFriend(User $user) : self
    {
        if ($user !== $this && !$this->friends->contains($user)) {
            $this->friends[] = $user;
            $user->addFriend($this);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return User
     */
    public function removeFriend(User $user) : self
    {
        if ($this->friends->contains($user)) {
            $this->friends->removeElement($user);
            $user->removeFriend($this);
        }

        return $this;
    }
}
