<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ChemicalProduct
 *
 * @ORM\Table(
 *  name="chemical_products",
 *  indexes={
 *      @ORM\Index(name="unit_type_id", columns={"unit_type_id"})
 *  }
 * )
 * @ORM\Entity
 * @UniqueEntity(fields="name", message="The chemical product name must be unique")
 */
class ChemicalProduct implements DarkroomEntityInterface
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
     * @Assert\Length(max=50)
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var UnitCategory
     *
     * @Assert\NotBlank(message="label must not be empty")
     *
     * @ORM\ManyToOne(targetEntity="UnitCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_type_id", referencedColumnName="id")
     * })
     */
    private $unitCategory;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="RecipeComponent", mappedBy="chemical")
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
     *
     * @return ChemicalProduct
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get unitType
     *
     * @return UnitCategory
     */
    public function getUnitCategory()
    {
        return $this->unitCategory;
    }

    /**
     * Set unitType
     *
     * @param UnitCategory $unitCategory
     *
     * @return ChemicalProduct
     */
    public function setUnitCategory(UnitCategory $unitCategory = null)
    {
        $this->unitCategory = $unitCategory;

        return $this;
    }

    /**
     * Add a new recipe
     * @param ChemicalRecipe $recipe
     */
    public function addRecipe(ChemicalRecipe $recipe){
        $this->recipes->add($recipe);
    }

    /**
     * Remove a recipe
     * @param ChemicalRecipe $recipe
     */
    public function removeRecipe(ChemicalRecipe $recipe){
        $this->recipes->removeElement($recipe);
    }
}
