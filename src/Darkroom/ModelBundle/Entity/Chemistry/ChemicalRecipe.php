<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ChemicalRecipe
 *
 * @ORM\Table(name="chemical_recipes", indexes={@ORM\Index(name="recipe_category_id", columns={"recipe_category_id"}),
 * @ORM\Index(name="manufacturer_id", columns={"manufacturer_id"})})
 * @ORM\Entity
 */
class ChemicalRecipe implements DarkroomEntityInterface
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
     * @Assert\length(max=50)
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var RecipeCategory
     *
     * @ORM\ManyToOne(targetEntity="RecipeCategory", inversedBy="recipes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recipe_category_id", referencedColumnName="id")
     * })
     */
    private $recipeCategory;

    /**
     * @var Manufacturer
     *
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="Manufacturer", inversedBy="recipes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
     * })
     */
    private $manufacturer;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="RecipeComponent", mappedBy="recipe")
     */
    private $components;

    /**
     *
     */
    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    /**
     * Get the recipe components
     *
     * @return ArrayCollection
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Set the recipe components
     *
     * @param ArrayCollection $components
     */
    public function setComponents($components)
    {
        foreach ($components as $item) {
            $item->setRecipe($this);
        }
        $this->components = $components;
    }

    /**
     * Add a new component to the recipe
     * @param RecipeComponent $component
     * @return $this
     */
    public function addComponent(RecipeComponent $component){
        $this->components->add($component);
        return $this;
    }

    /**
     * Remove a component from the recipe
     * @param RecipeComponent $component
     * @return $this
     */
    public function removeComponent(RecipeComponent $component){
        $this->components->removeElement($component);
        return $this;
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
     * Get label
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set label
     *
     * @param string $name
     *
     * @return ChemicalRecipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return ChemicalRecipe
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get recipeCategory
     *
     * @return RecipeCategory
     */
    public function getRecipeCategory()
    {
        return $this->recipeCategory;
    }

    /**
     * Set recipeCategory
     *
     * @param RecipeCategory $recipeCategory
     *
     * @return ChemicalRecipe
     */
    public function setRecipeCategory(RecipeCategory $recipeCategory = null)
    {
        $this->recipeCategory = $recipeCategory;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set manufacturer
     *
     * @param Manufacturer $manufacturer
     *
     * @return ChemicalRecipe
     */
    public function setManufacturer(Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
}
