<?php
/**
 * Created by PhpStorm.
 * User: seb
 * Date: 19/05/2015
 * Time: 17:40
 */

namespace Darkroom\AppBundle\Controller\Chemistry;


use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SolutionContainerController
 * @package Darkroom\AppBundle\Controller\Chemistry
 *
 * @Route("solution-container")
 */
class SolutionContainerController extends AbstractSimpleCrudController
{
    protected $baseServicesName = 'darkroom.solutioncontainer';
    protected $baseRoute = 'darkroom_app_chemistry_solutioncontainer';
    protected $controllerName = 'DarkroomAppBundle:Chemistry/SolutionContainer';

}