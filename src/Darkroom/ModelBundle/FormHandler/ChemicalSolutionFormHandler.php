<?php

namespace Darkroom\ModelBundle\FormHandler;

use Darkroom\ModelBundle\DomainManager\DomainManagerInterface;
use Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ChemicalSolutionFormHandler extends DefaultFormHandler
{

    /**
     * @var DomainManagerInterface
     */
    protected $componentManager;

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param DomainManagerInterface $solutionManager
     */

    public function __construct(FormInterface $form, Request $request, DomainManagerInterface $solutionManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->solutionManager = $solutionManager;
    }

    /**
     * @param ChemicalSolution $solution
     */
    public function onSuccess($solution)
    {
        $components = $this->form->get('components')->getData();
        $this->solutionManager->persist($solution, $components);
    }
}