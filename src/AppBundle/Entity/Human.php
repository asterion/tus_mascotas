<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\ValidateTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Human
 *
 * @ORM\Table(name="human")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HumanRepository")
 * @UniqueEntity("rut")
 */
class Human implements \JsonSerializable
{
    use ValidateTrait;

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
     * @ORM\Column(name="rut", type="string", length=20, unique=true)
     * @Assert\NotBlank()
     */
    private $rut;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=36)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=36)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=36)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=36)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity="Pet", mappedBy="human")
     */
    private $pets;

    public function __construct()
    {
        $this->pets = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set rut
     *
     * @param string $rut
     *
     * @return Human
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Human
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
     * @return Human
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

    public function __toString()
    {
        return sprintf('%s %s', $this->getFirstname(), $this->getLastname());
    }

    public function jsonSerialize()
    {
        return array(
            'id'        => $this->getId(),
            'rut'       => $this->getRut(),
            'firstname' => $this->getFirstname(),
            'lastname'  => $this->getLastname(),
        );
    }

    /**
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (!self::isRut($this->getRut())) {
            $context->buildViolation('RUT no valido')
                ->atPath('rut')
                ->addViolation();
        }
    }
}
