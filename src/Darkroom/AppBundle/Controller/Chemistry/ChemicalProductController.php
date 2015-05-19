<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ChemicalProductController
 * @package Darkroom\AppBundle\Controller\Chemistry
 *
 * @Route("/chemical-product")
 */
class ChemicalProductController extends AbstractSimpleCrudController
{
    protected $baseServicesName = 'darkroom.chemicalproduct';
    protected $baseRoute = 'darkroom_app_chemistry_chemicalproduct';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/ChemicalProduct';
}