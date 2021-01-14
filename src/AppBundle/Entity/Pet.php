<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pet
 *
 * @ORM\Table(name="pet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PetRepository")
 */
class Pet
{
    const DOG    = 1;
    const CAT    = 2;
    const FERRET = 3;
    const TURTLE = 4;
    const BIRD   = 5;
    const OTHER  = 6;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="chip", type="integer", unique=true)
     */
    private $chip;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=36)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=36, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=16)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=36)
     */
    private $color;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="kind", type="string", length=36)
     */
    private $kind;

    /**
     * @var bool
     *
     * @ORM\Column(name="steril", type="boolean")
     */
    private $steril;

    /**
     * @var string
     *
     * @ORM\Column(name="observations", type="text")
     */
    private $observations;

    /**
     * @ORM\ManyToOne(targetEntity="Human", inversedBy="pets")
     * @ORM\JoinColumn(name="human_id", referencedColumnName="id")
     */
    private $human;

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
     * Set chip
     *
     * @param integer $chip
     *
     * @return Pet
     */
    public function setChip($chip)
    {
        $this->chip = $chip;

        return $this;
    }

    /**
     * Get chip
     *
     * @return int
     */
    public function getChip()
    {
        return $this->chip;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Pet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Pet
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Pet
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Pet
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Pet
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Pet
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set kind
     *
     * @param string $kind
     *
     * @return Pet
     */
    public function setKind($kind)
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set steril
     *
     * @param boolean $steril
     *
     * @return Pet
     */
    public function setSteril($steril)
    {
        $this->steril = $steril;

        return $this;
    }

    /**
     * Get steril
     *
     * @return bool
     */
    public function getSteril()
    {
        return $this->steril;
    }

    /**
     * Set observations
     *
     * @param string $observations
     *
     * @return Pet
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set human
     *
     * @param \stdClass $human
     *
     * @return Pet
     */
    public function setHuman($human)
    {
        $this->human = $human;

        return $this;
    }

    /**
     * Get human
     *
     * @return \stdClass
     */
    public function getHuman()
    {
        return $this->human;
    }
}
