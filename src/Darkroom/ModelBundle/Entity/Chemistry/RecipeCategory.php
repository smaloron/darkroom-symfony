<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecipeCategory
 *
 * @ORM\Table(name="recipe_categories")
 * @ORM\Entity
 */
class RecipeCategory
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
     * @Assert\Length(max="50")
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ChemicalRecipe", mappedBy="recipeCategory")
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
     * @return RecipeCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
