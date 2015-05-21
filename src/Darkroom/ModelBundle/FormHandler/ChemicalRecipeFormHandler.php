<?php

namespace Darkroom\ModelBundle\FormHandler;

use Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe;
use Darkroom\ModelBundle\EntityManager\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ChemicalRecipeFormHandler extends DefaultFormHandler{

    /**
     * @var EntityManagerInterface
     */
    protected $componentManager;

    /**
     * @var EntityManagerInterface
     */
    protected $recipeManager;

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param EntityManagerInterface $recipeManager
     * @param EntityManagerInterface $componentManager
     */
    public function __construct(FormInterface $form, Request $request, EntityManagerInterface $recipeManager, EntityManagerInterface $componentManager){
        $this->form = $form;
        $this->request = $request;
        $this->recipeManager = $recipeManager;
        $this->componentManager = $componentManager;
    }

    /**
     * @param ChemicalRecipe $recipe
     */
    public function onSuccess($recipe){
        //$recipeId = $recipe->getId();
        if($recipe->getId() != null){

            $originalComponents = $this->componentManager->getRepository()->findByRecipe($recipe);
            foreach($originalComponents as $item){
                if(! $recipe->getComponents()->contains($item)){
                    $this->componentManager->delete($item);
                    $this->componentManager->flush();
                }
            }
        }

        $components = $this->form->get('components')->getData();
        $recipe->getComponents()->clear();

        //Persist the recipe in order to set the primary key
        $this->recipeManager->persist($recipe);
        $this->recipeManager->flush();

        //Add the components
        foreach($components as $item){
            $item->setRecipe($recipe);
            $this->recipeManager->persist($item);
        }
        $this->recipeManager->flush();
    }

}