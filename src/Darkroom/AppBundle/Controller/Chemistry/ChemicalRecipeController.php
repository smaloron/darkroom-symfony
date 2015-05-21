<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ChemicalRecipeController
 * @package Darkroom\AppBundle\Controller\Chemistry
 *
 * @Route("/chemical-recipe")
 */
class ChemicalRecipeController extends AbstractSimpleCrudController{

    protected $baseServicesName = 'darkroom.chemicalrecipe';
    protected $baseRoute = 'darkroom_app_chemistry_chemicalrecipe';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/ChemicalRecipe';



}