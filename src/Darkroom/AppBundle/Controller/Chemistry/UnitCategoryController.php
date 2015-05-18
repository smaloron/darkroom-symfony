<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;

/**
 * This class is the controller for the unitCategory features
 * It exposes CRUD functionality
 * Class UnitCategoryController
 * @package Darkroom\AppBundle\Controller
 * @Route("unit-category")
 */
class UnitCategoryController extends AbstractSimpleCrudController
{

    public function __construct(){
        $this->baseServicesName = 'darkroom.unitcategory';
        $this->baseRoute = 'darkroom_app_chemistry_unitcategory';
        $this->controllerName = 'DarkroomAppBundle:Chemistry/UnitCategory';

        parent::__construct();
    }
}
