<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SolutionContainer
 *
 * @ORM\Table(name="solution_containers", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code"})})
 * @ORM\Entity
 */
class SolutionContainer implements EntityInterface
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
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=15)
     *
     * @ORM\Column(name="code", type="string", length=15, nullable=false)
     */
    private $code;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0)
     *
     * @ORM\Column(name="volume_capacity", type="float", precision=10, scale=0, nullable=false)
     */
    private $volumeCapacity;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ChemicalSolution", mappedBy="container")
     */
    private $solutions;

    /**
     *
     */
    public function __construct()
    {
        $this->solutions = new ArrayCollection();
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
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return SolutionContainer
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get volumeCapacity
     *
     * @return float
     */
    public function getVolumeCapacity()
    {
        return $this->volumeCapacity;
    }

    /**
     * Set volumeCapacity
     *
     * @param float $volumeCapacity
     * @return SolutionContainer
     */
    public function setVolumeCapacity($volumeCapacity)
    {
        $this->volumeCapacity = $volumeCapacity;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return SolutionContainer
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }
}
