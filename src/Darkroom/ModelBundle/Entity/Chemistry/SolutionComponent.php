<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SolutionComponent
 *
 * @ORM\Table(name="solution_components", indexes={@ORM\Index(name="solution_component_to_master_solution", columns={"solution_id"}), @ORM\Index(name="solution_component_to_element_solution", columns={"component_id"})})
 * @ORM\Entity
 */
class SolutionComponent implements DarkroomEntityInterface
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
     * @var float
     *
     * @Assert\NotBlank(message="The component volume cannot be blank")
     * @Assert\GreaterThan(value=0, message="The component volume must be greater than 0")
     *
     * @ORM\Column(name="volume", type="float", precision=10, scale=0, nullable=false)
     */
    private $volume;

    /**
     * @var ChemicalSolution
     *
     * @Assert\NotBlank(message="The component cannot be blank")
     *
     * @ORM\ManyToOne(targetEntity="ChemicalSolution", inversedBy="components")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="component_id", referencedColumnName="id")
     * })
     */
    private $component;

    /**
     * @var ChemicalSolution
     *
     * @ORM\ManyToOne(targetEntity="ChemicalSolution", inversedBy="dependantSolutions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="solution_id", referencedColumnName="id")
     * })
     */
    private $solution;


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
     * Get solution
     *
     * @return ChemicalSolution
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Set solution
     *
     * @param ChemicalSolution $solution
     * @return SolutionComponent
     */
    public function setSolution(ChemicalSolution $solution = null)
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Check if the choosen volume of the component is coherent
     * with the available volume of the component solution
     * @Assert\True(message="The component volume cannot be greater than the available volume of the solution")
     *
     * @return bool
     */
    public function isComponentVolumeValid()
    {
        $componentVolumeLeft = $this->getComponent()->getVolumeLeft();

        return $componentVolumeLeft >= $this->getVolume();
    }

    /**
     * Get component
     *
     * @return ChemicalSolution
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set component
     *
     * @param ChemicalSolution $component
     * @return SolutionComponent
     */
    public function setComponent(ChemicalSolution $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get volume
     *
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set volume
     *
     * @param float $volume
     * @return SolutionComponent
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

}