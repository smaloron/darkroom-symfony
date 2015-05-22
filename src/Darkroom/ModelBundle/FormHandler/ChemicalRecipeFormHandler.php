<?php

namespace Darkroom\ModelBundle\FormHandler;

use Darkroom\ModelBundle\DomainManager\DomainManagerInterface;
use Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ChemicalRecipeFormHandler extends DefaultFormHandler{

    /**
     * @var DomainManagerInterface
     */
    protected $componentManager;

    /**
     * @var DomainManagerInterface
     */
    protected $recipeManager;

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param DomainManagerInterface $recipeManager
     * @param DomainManagerInterface $componentManager
     */

    public function __construct(FormInterface $form, Request $request, DomainManagerInterface $recipeManager, DomainManagerInterface $componentManager){
        $this->form = $form;
        $this->request = $request;
        $this->recipeManager = $recipeManager;
        $this->componentManager = $componentManager;
    }

    /**
     * @param ChemicalRecipe $recipe
     */
    public function onSuccess($recipe){
        $components = $this->form->get('components')->getData();
        $this->recipeManager->persist($recipe, $components);
    }

}