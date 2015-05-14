<?php

namespace Smaloron\Darkroom\ModelBundle\Entity\Chemistry;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SolutionComponent
 *
 * @ORM\Table(name="solution_components", indexes={@ORM\Index(name="solution_component_to_master_solution", columns={"solution_id"}), @ORM\Index(name="solution_component_to_element_solution", columns={"component_id"})})
 * @ORM\Entity
 */
class SolutionComponent
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
     * @ORM\Column(name="volume", type="float", precision=10, scale=0, nullable=false)
     */
    private $volume;

    /**
     * @var \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution
     *
     * @ORM\ManyToOne(targetEntity="ChemicalSolution")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="component_id", referencedColumnName="id")
     * })
     */
    private $component;

    /**
     * @var \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution
     *
     * @ORM\ManyToOne(targetEntity="ChemicalSolution")
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

    /**
     * Get component
     *
     * @return \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set component
     *
     * @param \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution $component
     * @return SolutionComponent
     */
    public function setComponent(ChemicalSolution $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get solution
     *
     * @return \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Set solution
     *
     * @param \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution $solution
     * @return SolutionComponent
     */
    public function setSolution(ChemicalSolution $solution = null)
    {
        $this->solution = $solution;

        return $this;
    }
}