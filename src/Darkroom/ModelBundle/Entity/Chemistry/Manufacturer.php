<?php

namespace Smaloron\Darkroom\ModelBundle\Entity\Chemistry;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Manufacturer
 *
 * @ORM\Table(name="manufacturers")
 * @ORM\Entity
 */
class Manufacturer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="50")
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ChemicalRecipe", mappedBy="manufacturer")
     */
    private $recipes;

    /**
     *
     */
    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Manufacturer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
