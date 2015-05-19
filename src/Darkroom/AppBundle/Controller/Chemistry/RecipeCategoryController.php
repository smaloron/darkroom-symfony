<?php

namespace Darkroom\AppBundle\Controller\Chemistry;


use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * This class is the controller for the recipe categry features
 * It exposes CRUD functionality
 * Class RecipeCategoryController
 * @package Darkroom\AppBundle\Controller
 *
 * @Route("recipe-category")
 */
class RecipeCategoryController extends AbstractSimpleCrudController
{
    protected $baseServicesName = 'darkroom.recipecategory';
    protected $baseRoute = 'darkroom_app_chemistry_recipecategory';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/RecipeCategory';

}