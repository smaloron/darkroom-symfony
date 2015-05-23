<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ChemicalSolutionController
 * @package Darkroom\AppBundle\Controller\Chemistry
 *
 * @Route("/chemical-solution")
 */
class ChemicalSolutionController extends AbstractSimpleCrudController
{

    protected $baseServicesName = 'darkroom.chemicalsolution';
    protected $baseRoute = 'darkroom_app_chemistry_chemicalsolution';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/ChemicalSolution';

}