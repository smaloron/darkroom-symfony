<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;

/**
 * Class UnitController
 * @package Darkroom\AppBundle\Controller\Chemistry
 *
 * @Route("unit")
 */
class UnitController extends AbstractSimpleCrudController
{
    protected $baseServicesName = 'darkroom.unit';
    protected $baseRoute = 'darkroom_app_chemistry_unit';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/Unit';
}