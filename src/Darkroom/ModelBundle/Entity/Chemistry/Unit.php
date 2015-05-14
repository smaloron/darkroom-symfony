<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Unit
 *
 * @ORM\Table(
 *  name="units",
 *  indexes={
 *      @ORM\Index(name="unit_parent", columns={"unit_parent"})
 *  }
 * )
 * @ORM\Entity
 */
class Unit
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
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=10)
     *
     * @ORM\Column(name="abbrev", type="string", length=10, nullable=false)
     */
    private $abbrev;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0)
     *
     * @ORM\Column(name="conversion_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $conversionRate = '1';


    /**
     * @var UnitCategory
     *
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="UnitCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_category_id", referencedColumnName="id")
     * })
     */
    private $unitCategory;


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
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get abbrev
     *
     * @return string
     */
    public function getAbbrev()
    {
        return $this->abbrev;
    }

    /**
     * Set abbrev
     *
     * @param string $abbrev
     *
     * @return Unit
     */
    public function setAbbrev($abbrev)
    {
        $this->abbrev = $abbrev;

        return $this;
    }

    /**
     * Get conversionRate
     *
     * @return float
     */
    public function getConversionRate()
    {
        return $this->conversionRate;
    }

    /**
     * Set conversionRate
     *
     * @param float $conversionRate
     *
     * @return Unit
     */
    public function setConversionRate($conversionRate)
    {
        $this->conversionRate = $conversionRate;

        return $this;
    }

    /**
     * Get unitCategory
     *
     * @return UnitCategory
     */
    public function getUnitCategory()
    {
        return $this->unitCategory;
    }

    /**
     * Set unitCategory
     *
     * @param UnitCategory $unitCategory
     *
     * @return Unit
     */
    public function setUnitCategory(UnitCategory $unitCategory = null)
    {
        $this->unitCategory = $unitCategory;

        return $this;
    }
}
