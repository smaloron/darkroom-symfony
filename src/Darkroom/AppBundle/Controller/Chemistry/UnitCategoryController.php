<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkroom\AppBundle\Controller\AbstractBaseCrudController;
use Darkroom\ModelBundle\Form\Chemistry\UnitCategoryType;

/**
 * This class is the controller for the unitCategory features
 * It exposes CRUD functionality
 * Class UnitCategoryController
 * @package Darkroom\AppBundle\Controller
 * @Route("unit-category")
 */
class UnitCategoryController extends AbstractBaseCrudController
{
    /**
     *
     */
    public function __construct()
    {
        $this->baseRouteName = 'darkroom_app_chemistry_unitcategory';
        $this->emServiceName = 'Darkroom.model.manager.unit_category';
        $this->controllerName = 'DarkroomAppBundle:Chemistry/UnitCategory';
    }
}
