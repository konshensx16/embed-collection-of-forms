<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @ORM\OneToMany(targetEntity="Exp", mappedBy="user", cascade={"persist"})
     */
    private $exp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exp = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add exp
     *
     * @param \AppBundle\Entity\Exp $exp
     *
     * @return User
     */
    public function addExp(\AppBundle\Entity\Exp $exp)
    {
        $this->exp[] = $exp;
        // setting the current user to the $exp,
        // adapt this to whatever you are trying to achieve
        $exp->setUser($this);
        return $this;
    }

    /**
     * Remove exp
     *
     * @param \AppBundle\Entity\Exp $exp
     */
    public function removeExp(\AppBundle\Entity\Exp $exp)
    {
        $this->exp->removeElement($exp);
    }

    /**
     * Get exp
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExp()
    {
        return $this->exp;
    }
}
