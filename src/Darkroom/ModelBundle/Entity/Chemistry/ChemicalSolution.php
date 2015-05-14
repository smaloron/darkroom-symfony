<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

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
 * @ORM\Entity
 */
class ChemicalSolution
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
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
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
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="ChemicalRecipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * })
     */
    private $recipe;

    /**
     * Collection representing all the components of this chemical solution
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SolutionComponent", mappedBy="component")
     */
    private $components;

    /**
     * Collection representing all the solutions that use this solution as a component
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SolutionComponent", mappedBy="solution")
     */
    private $dependantSolutions;

    /**
     *
     */
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
     * Get volumeLeft
     *
     * @return float
     */
    public function getVolumeLeft()
    {
        return $this->getInitialVolume() - $this->getUsedVolume();
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
        return $this->waterVolume + $this->getComponentsVolume();
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
        return $this->waterVolume;
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

    /**
     * @return bool
     *
     * @Assert\True()
     */
    public function checkContainerVolume(){
        $check = true;
        if($this->container != null){
            $containerVolume = $this->container->getVolumeCapacity();
            $check = $containerVolume >= $this->getInitialVolume();
        }

        return $check;
    }

    /**
     * @return bool
     *
     * @Assert\True()
     */
    public function checkComponentsVolume(){
        return $this->waterVolume + $this->getComponentsVolume() == $this->initialVolume;
    }


}
