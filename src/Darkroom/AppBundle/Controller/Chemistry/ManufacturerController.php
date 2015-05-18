<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ManufacturerController
 * @package Darkroom\AppBundle\Controller\Chemistry
 *
 * @Route("manufacturer")
 */
class ManufacturerController extends AbstractSimpleCrudController{
    protected $baseServicesName = 'darkroom.manufacturer';
    protected $baseRoute = 'darkroom_app_chemistry_manufacturer';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/Manufacturer';
}