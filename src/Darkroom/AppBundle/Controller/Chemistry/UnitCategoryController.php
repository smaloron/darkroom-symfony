<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;

/**
 * This class is the controller for the unitCategory features
 * It exposes CRUD functionality
 * Class UnitCategoryController
 * @package Darkroom\AppBundle\Controller
 *
 * @Route("unit-category")
 */
class UnitCategoryController extends AbstractSimpleCrudController
{
    protected $baseServicesName = 'darkroom.unitcategory';
    protected $baseRoute = 'darkroom_app_chemistry_unitcategory';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/UnitCategory';
}
