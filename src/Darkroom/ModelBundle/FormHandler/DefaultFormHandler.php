<?php

namespace Darkroom\ModelBundle\FormHandler;

use Darkroom\ModelBundle\DomainManager\DomainManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class provides a basic form handling service
 *
 * Class DefaultFormHandler
 * @package Darkroom\ModelBundle\FormHandler
 */
class DefaultFormHandler implements FormHandlerInterface
{

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var DomainManagerInterface
     */
    protected $entityManager;

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param DomainManagerInterface $entityManager
     */
    public function __construct(FormInterface $form, Request $request, DomainManagerInterface $entityManager){
        $this->form = $form;
        $this->request = $request;
        $this->entityManager = $entityManager;
    }

    /**
     * @return FormInterface
     */
    public function getForm(){
        return $this->form;
    }

    /**
     * Process the form and call onSuccess if everything goes well
     *
     * @param null $entity
     * @return bool
     */
    public function process($entity = null){
        $success = false;

        if($this->request->getMethod() === 'POST'){

            if(isset($entity)){
                $this->form->setData($entity);
            }

            $this->form->handleRequest($this->request);

            if($this->form->isValid()){
                $success = true;
                $this->onSuccess($this->form->getData());
            }
        }
        return $success;
    }

    /**
     * @param $entity
     */
    public function onSuccess($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}