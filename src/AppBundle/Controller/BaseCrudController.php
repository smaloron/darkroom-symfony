<?php

namespace Smaloron\Darkroom\AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Darkroom\ModelBundle\EntityManager\BaseEntityManager;
use Darkroom\ModelBundle\Entity\EntityInterface;

/**
 * Class BaseCrudController
 * @package Smaloron\Darkroom\AppBundle\Controller
 */
class BaseCrudController extends Controller{

    /**
     * @var array
     */
    protected $formOption;

    /**
     * @var string
     */
    protected $emServiceName;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $baseRouteName;

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * Shows the list of unit categories and provides a form to add or update categories
     *
     * @param int           $id
     * @param FormInterface $form
     *
     * @Route("/")
     * @Route("/{id}", requirements={"id"="\d+"})
     * @Template()
     *
     * @return array
     */
    public function indexAction($id = null, FormInterface $form = null)
    {
        $entityManager = $this->getEntityManager();
        $modelData = $entityManager->getAll();
        $formModel = $entityManager->getOne($id);
        if (!isset($form)) {
            $form = $this->getForm($formModel, $id);
        }

        return array('model' => $modelData, 'form' => $form->createView(), 'id' => $id);
    }

    /**
     * @param EntityInterface $entity
     *
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @return RedirectResponse
     */
    public function deleteAction(EntityInterface $entity)
    {
        $entityManager = $this->getEntityManager();

        $entityManager->delete($entity);
        $entityManager->flush();

        return $this->redirectToRoute($this->baseRouteName.'_index');
    }

    /**
     * @param Request $request
     * @param int     $id
     * @Route("/persist/{id}", requirements={"id"="\d+"})
     *
     * @return array
     */
    public function persistAction(Request $request, $id = null)
    {
        $entityManager = $this->getEntityManager();

        $formModel = $entityManager->getOne($id);
        $entityManager->setFormOptions($this->getFormOptions(null));
        $formProcess = $entityManager->save($formModel, $request);

        if ($formProcess['success']) {
            $response = $this->redirectToRoute($this->baseRouteName.'_index');
            $entityManager->flush();
        } else {
            $form = $formProcess['form'];
            $response = $this->forward($this->controllerName.':index', array('form' => $form));
        }

        return $response;
    }

    /**
     * @param EntityInterface $entity
     * @param int $id
     *
     * @return FormInterface
     */
    private function getForm(EntityInterface $entity, $id = null)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->setFormOptions($this->getFormOptions($id));
        $form = $entityManager->getForm($entity);

        return $form;
    }

    /**
     * @param int $id
     * @return array
     */
    private function getFormOptions($id)
    {
        $options = [
            'method' => 'POST',
            'action' => $this->generateUrl($this->baseRouteName.'_persist', array('id' => $id)),
        ];

        return $options;
    }

    /**
     * @return BaseEntityManager
     */
    private function getEntityManager(){
        return $this->get($this->emServiceName);
    }


}