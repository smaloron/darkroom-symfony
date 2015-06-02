<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Darkroom\ModelBundle\Repository\ChemicalSolutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ChemicalSolution
 *
 * @ORM\Table(name="chemical_solutions",
 *  indexes={
 *      @ORM\Index(name="chemical_solution_to_recipe", columns={"recipe_id"}),
 *      @ORM\Index(name="container_id", columns={"container_id"})
 *  })
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @ORM\Entity(repositoryClass="Darkroom\ModelBundle\Repository\ChemicalSolutionRepository")
 */
class ChemicalSolution implements DarkroomEntityInterface
{
    Const DILUTION_TRESHOLD = 15;

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
     * @Assert\NotBlank(message="The name of the solution cannot be blank")
     * @Assert\length(max=50)
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(max=50)
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="The date mixed cannot be blank")
     * @Assert\DateTime
     *
     * @ORM\Column(name="date_mixed", type="date", nullable=false)
     */
    private $dateMixed;

    /**
     * @var \DateTime
     * @Assert\DateTime
     * @ORM\Column(name="date_dumped", type="date", nullable=true)
     */
    private $dateDumped;

    /**
     * @var string
     *
     * @ORM\Column(name="dilution", type="string", length=10, nullable=true)
     */
    private $dilution;

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(value=0)
     *
     * @ORM\Column(name="initial_volume", type="float", precision=10, scale=0, nullable=false)
     */
    private $initialVolume = '0';

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(value=0)
     *
     * @ORM\Column(name="volume_left", type="float", precision=10, scale=0, nullable=false)
     */
    private $volumeLeft = '0';

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(value=0)
     *
     * @ORM\Column(name="water_volume", type="float", precision=10, scale=0, nullable=false)
     */
    private $waterVolume = '0';

    /**
     * @var boolean
     * @Assert\Type(type="bool")
     *
     * @ORM\Column(name="stock_solution", type="boolean", nullable=false)
     */
    private $stockSolution = false;

    /**
     * @var boolean
     * @Assert\Type(type="bool")
     *
     * @ORM\Column(name="one_use", type="boolean", nullable=false)
     */
    private $oneUse = false;

    /**
     * @var SolutionContainer
     *
     * @ORM\ManyToOne(targetEntity="SolutionContainer", inversedBy="solutions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="container_id", referencedColumnName="id")
     * })
     */
    private $container;

    /**
     * @var ChemicalRecipe
     *
     * @ORM\ManyToOne(targetEntity="ChemicalRecipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * })
     */
    private $recipe;

    /**
     * @var RecipeCategory
     *
     * @ORM\ManyToOne(targetEntity="RecipeCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * Collection representing all the components of this chemical solution
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SolutionComponent", mappedBy="solution", cascade={"remove"})
     */
    private $components;

    /**
     * Collection representing all the solutions that use this solution as a component
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SolutionComponent", mappedBy="component")
     */
    private $dependantSolutions;


    public function __construct()
    {
        $this->components = new ArrayCollection();
        $this->dependantSolutions = new ArrayCollection();
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
     * @return ChemicalSolution
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set note
     *
     * @param string $notes
     *
     * @return ChemicalSolution
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get dateMixed
     *
     * @return \DateTime
     */
    public function getDateMixed()
    {
        return $this->dateMixed;
    }

    /**
     * Set dateMixed
     *
     * @param \DateTime $dateMixed
     *
     * @return ChemicalSolution
     */
    public function setDateMixed($dateMixed)
    {
        $this->dateMixed = $dateMixed;

        return $this;
    }

    /**
     * Get dateDumped
     *
     * @return \DateTime
     */
    public function getDateDumped()
    {
        return $this->dateDumped;
    }

    /**
     * Set dateDumped
     *
     * @param \DateTime $dateDumped
     *
     * @return ChemicalSolution
     */
    public function setDateDumped($dateDumped)
    {
        $this->dateDumped = $dateDumped;

        return $this;
    }

    /**
     * Get dilution
     *
     * @return string
     */
    public function getDilution()
    {
        return $this->dilution;
    }

    /**
     * Set dilution
     *
     * @param string $dilution
     *
     * @return ChemicalSolution
     */
    public function setDilution($dilution)
    {
        $this->dilution = $dilution;

        return $this;
    }

    /**
     * @return RecipeCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param RecipeCategory $category
     *
     * @return RecipeCategory
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get stockSolution
     *
     * @return boolean
     */
    public function getStockSolution()
    {
        return $this->stockSolution;
    }

    /**
     * Set stockSolution
     *
     * @param boolean $stockSolution
     *
     * @return ChemicalSolution
     */
    public function setStockSolution($stockSolution)
    {
        $this->stockSolution = $stockSolution;

        return $this;
    }

    /**
     * Get oneUse
     *
     * @return boolean
     */
    public function getOneUse()
    {
        return $this->oneUse;
    }

    /**
     * Set oneUse
     *
     * @param boolean $oneUse
     *
     * @return ChemicalSolution
     */
    public function setOneUse($oneUse)
    {
        $this->oneUse = $oneUse;

        return $this;
    }

    /**
     * Get container
     *
     * @return SolutionContainer
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set container
     *
     * @param SolutionContainer $container
     *
     * @return ChemicalSolution
     */
    public function setContainer(SolutionContainer $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return ChemicalRecipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set recipe
     *
     * @param ChemicalRecipe $recipe
     *
     * @return ChemicalSolution
     */
    public function setRecipe(ChemicalRecipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDependantSolutions()
    {
        return $this->dependantSolutions;
    }

    /**
     * @param ArrayCollection $dependantSolutions
     */
    public function setDependantSolutions($dependantSolutions)
    {
        $this->dependantSolutions = $dependantSolutions;
    }

    public function addDependantSolution(SolutionComponent $dependant)
    {
        $this->dependantSolutions->add($dependant);

        return $this;
    }

    public function removeDependantSolution(SolutionComponent $dependant)
    {
        $this->dependantSolutions->removeElement($dependant);
    }

    /**
     * Add a new component to the solution
     * @param SolutionComponent $component
     * @return $this
     */
    public function addComponent(SolutionComponent $component)
    {
        $this->components->add($component);

        return $this;
    }

    /**
     * Remove a component from the solution
     * @param SolutionComponent $component
     */
    public function removeComponent(SolutionComponent $component)
    {
        $this->components->removeElement($component);
    }

    /**
     * Check if the container's capacity matches with the solution's volume
     * @return bool
     *
     * @Assert\True(message="The container's capacity does not match with the solution's volume")
     */
    public function isContainerVolumeValid()
    {
        $check = true;
        if ($this->container != null) {
            $containerVolume = $this->container->getVolumeCapacity();
            $check = $containerVolume >= $this->getInitialVolume();
        }

        return $check;
    }

    /**
     * Get initialVolume
     *
     * @return float
     */
    public function getInitialVolume()
    {
        return $this->getTotalVolume();
    }

    /**
     * Set initialVolume
     *
     * @param float $initialVolume
     *
     * @return ChemicalSolution
     */
    public function setInitialVolume($initialVolume)
    {
        $this->initialVolume = $initialVolume;

        return $this;
    }

    /**
     * Calculate the total volume of the solution
     * @return float
     */
    public function getTotalVolume()
    {
        return $this->initialVolume;
    }

    /**
     * Check if the total volume of the solution is equal
     * to the sum of the water volume and the components volume
     * @return bool
     *
     * @Assert\True(message="
     * The sum of the components volume cannot be greater than the total volume of the solution"
     * )
     */
    public function isComponentVolumeValid()
    {
        return $this->getComponentsVolume() <= $this->initialVolume;

    }

    /**
     * Calculate the volume of all the chemical components of the solution
     * @return float
     */
    public function getComponentsVolume()
    {
        $componentVolume = 0.0;

        foreach ($this->components as $item) {
            $componentVolume += $item->getVolume();
        }

        return $componentVolume;
    }

    /**
     * @return bool
     * @Assert\True(message="A solution cannot be declared as a stock solution and be a one use solution")
     */
    public function isOneUseValid()
    {
        $valid = true;
        if ($this->oneUse || $this->stockSolution) {
            $valid = !($this->oneUse == $this->stockSolution);
        }

        return $valid;
    }

    /**
     * @return bool
     * @Assert\True(message="A solution can either have components or recipe but not both")
     */
    public function isRecipeValid()
    {
        return !($this->hasComponents() == $this->hasRecipe());
    }

    public function hasComponents()
    {
        return $this->getComponents()->count() > 0;
    }

    /**
     * Get the solution components
     *
     * @return ArrayCollection
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Set the solution components
     *
     * @param ArrayCollection $components
     */
    public function setComponents($components)
    {
        foreach ($components as $item) {
            $item->setSolution($this);
        }
        $this->components = $components;
    }

    public function hasRecipe()
    {
        return isset($this->recipe);
    }

    /**
     * Calculate the volume left and the water volume of the solution
     *
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function setCalculatedValues()
    {
        $this->volumeLeft = $this->getVolumeLeft();//$this->initialVolume - $this->getUsedVolume();
        $this->waterVolume = $this->getWaterVolume();//$this->initialVolume - $this->getComponentsVolume();
        $this->calculateDilution();

        if (isset($this->recipe)) {
            $this->category = $this->recipe->getRecipeCategory();
        }
    }

    /**
     * Get volumeLeft
     *
     * @return float
     */
    public function getVolumeLeft()
    {
        $initialVolume = $this->getInitialVolume();
        $usedVolume = $this->getUsedVolume();

        return $initialVolume - $usedVolume;
    }

    /**
     * Set volumeLeft
     *
     * @param float $volumeLeft
     *
     * @return ChemicalSolution
     */
    public function setVolumeLeft($volumeLeft)
    {
        $this->volumeLeft = $volumeLeft;

        return $this;
    }

    /**
     * Calculate the volume of this solution used by other solutions
     * @return float
     */
    public function getUsedVolume()
    {
        $usedVolume = 0.0;
        foreach ($this->dependantSolutions as $item) {
            $usedVolume += $item->getVolume();
        }

        return $usedVolume;
    }

    /**
     * Get waterVolume
     *
     * @return float
     */
    public function getWaterVolume()
    {
        //return $this->waterVolume;
        return $this->initialVolume - $this->getComponentsVolume();

    }

    /**
     * Set waterVolume
     *
     * @param float $waterVolume
     *
     * @return ChemicalSolution
     */
    public function setWaterVolume($waterVolume)
    {
        $this->waterVolume = $waterVolume;

        return $this;
    }

    /**
     * Calculate the dilution factor of the solution
     * for example for a 1000 ml solution with a 100 ml component
     * the dilution factor is 1+9
     */
    public function calculateDilution()
    {
        if ($this->components->count() == 0) {
            $dilutionString = 1;
        } else {
            $nbComponents = $this->components->count();
            $dilutions = array ();
            foreach ($this->components as $item) {
                if ($item->getVolume() > 0) {
                    $ratio = $this->initialVolume / $item->getVolume();
                    //Past this treshold it is customary to promote even numbers
                    //even though it leads to false results
                    if ($ratio <= self::DILUTION_TRESHOLD) {
                        $ratio -= $nbComponents;
                    }
                    $dilutions[] = $ratio;
                }
            }
            $dilutionString = '1+' . implode('+', $dilutions);
        }

        $this->dilution = $dilutionString;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        $name = '';
        if (isset($this->recipe)) {
            $name .= $this->recipe->getManufacturer()->getName();
            $name .= ' ' . $this->recipe->getName() . ' ';
        }
        $name .= $this->name . ' (' . $this->volumeLeft . ' ml)';

        return $name;
    }


}
