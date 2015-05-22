<?php

namespace Darkroom\AppBundle\Controller\Chemistry;

use Darkroom\AppBundle\Controller\AbstractSimpleCrudController;
use Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/ajax-get-unit-list/{id}", options={"expose"=true})
     */
    public function ajaxGetUnitListAction($id){
        try {
            /**
             * @var ChemicalProduct
             */
            $product = $this->getEntityManager()->getOneById($id);
            $unitCategory = $product->getUnitCategory();
            $unitManager = $this->get('darkroom.unit.domainmanager');
            $units = $unitManager->getRepository()->findBy(array('unitCategory' => $unitCategory));
            $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new
            JsonEncoder()));
            $json = $serializer->serialize($units, 'json');

            $response = new JsonResponse(array('success' => true, 'data' => $json));
        } catch (Exception $e){
            $response = new JsonResponse(array('success' => false));
        }


        return $response;
    }
}