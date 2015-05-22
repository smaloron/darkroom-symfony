<?php

namespace Darkroom\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Darkroom\ModelBundle\FormHandler\FormHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Darkroom\ModelBundle\EntityManager\EntityManagerInterface;

/**
 * This abstract class provides methods
 * to manage the basics crud functions
 * it uses services for the entity manager, the form handler and the form itself
 *
 * Class AbstractSimpleCrudController
 * @package Darkroom\AppBundle\Controller
 */
abstract class AbstractSimpleCrudController extends Controller {

    /**
     * @var string
     */
    protected $entityManagerName;

    /**
     * @var string
     */
    protected $formServiceName;

    /**
     * @var string
     */
    protected $formHandlerName;

    /**
     * to be defined in the concrete classes
     * @var string
     */
    protected $baseServicesName;

    /**
     * to be defined in the concrete classes
     * @var string
     */
    protected $baseRoute;

    /**
     * to be defined in the concrete classes
     * @var string
     */
    protected $controllerName;

    /**
     *
     */
    public function __construct(){
        $this->setEntityManagerName();
        $this->setFormHandlerName();
        $this->setFormServiceName();
    }

    /**
     * Set the EntityManagerName if not previously defined
     */
    protected function setEntityManagerName()
    {
        if(!isset($this->entityManagerName)){
            $this->entityManagerName = $this->baseServicesName. '.entitymanager';
        }
    }

    /**
     * set the FormHandlerName if not previously defined
     */
    public function setFormHandlerName()
    {
        if(!isset($this->formHandlerName)){
            $this->formHandlerName = $this->baseServicesName.'.form.handler';
        }
    }

    /**
     * sets the FormServiceName if not previously defined
     */
    public function setFormServiceName()
    {
        if(!isset($this->formServiceName)){
            $this->formServiceName = $this->baseServicesName.'.form';
        }
    }



    /**
     * Show a table of the entities
     * and a form to edit existing entities or add new ones
     *
     * @param int|null $id
     * @param FormInterface $form
     *
     * @Route("/", options={"expose"=true})
     * @Route("/{id}", requirements={"id"="\d+"}, options={"expose"=true})
     * @Template()
     *
     * @return array
     */
    public function indexAction($id = null, FormInterface $form = null)
    {
        $em = $this->getEntityManager();
        $records = $em->getAll();

        if(! isset($form)){
            $form = $this->getForm();
        }

        // In case of edited record,
        // hydrate the form with the entity data
        if($id != null){
            $entity = $em->getOneById($id);
            $form->setData($entity);
        }

        $action = $this->generateUrl($this->baseRoute.'_persist', array('id' => $id));

        return array( 'model' => $records, 'form' => $form->createView(), 'action' => $action, 'id' =>$id );
    }

    /**
     * Persists an entity used to create or update records
     *
     * @Route("/persist/{id}", requirements={"id"="\d+"})
     *
     * @param null $id
     * @return RedirectResponse|Response
     */
    public function persistAction($id=null){
        $formHandler = $this->getFormHandler();
        $entity = null;
        $entityManager = $this->getEntityManager();

        if($id != null){
            $entity = $entityManager->getOneById($id);
        }

        if($formHandler->process($entity)){
            $response = $this->redirectToRoute($this->baseRoute.'_index');
        } else {
            $form = $this->get($this->formServiceName);
            $response = $this->forward($this->controllerName.':index', array('form' => $form));
        }

        return $response;
    }

    /**
     * Delete an entity
     *
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     *
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction($id){
        $this->getEntityManager()->deleteById($id);
        $this->getEntityManager()->flush();
        return $this->redirectToRoute($this->baseRoute.'_index');
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(){
        return $this->get($this->entityManagerName);
    }

    /**
     * @return FormInterface
     */
    public function getForm(){
        return $this->get($this->formServiceName);
    }

    /**
     * @return FormHandlerInterface
     */
    public function getFormHandler(){
        return $this->get($this->formHandlerName);
    }
}