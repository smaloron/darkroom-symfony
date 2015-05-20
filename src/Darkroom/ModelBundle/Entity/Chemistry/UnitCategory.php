<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UnitCategory
 *
 * @ORM\Table(name="unit_categories")
 * @ORM\Entity
 * @UniqueEntity(fields="name", message="The unit category must be unique")
 */
class UnitCategory implements EntityInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false, unique=true)
     */
    private $name;


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
     *
     * @return UnitCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
