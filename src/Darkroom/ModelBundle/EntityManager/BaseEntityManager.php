<?php
namespace Darkroom\ModelBundle\EntityManager;

use Doctrine\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Darkroom\ModelBundle\Entity\EntityInterface;
/**
 * This class is an abstract entity manager providing the base crud features
 * Class AbstractEntityManager
 * @package Darkroom\ModelBundle\EntityManager
 */
class BaseEntityManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formClassName;

    /**
     * @var array
     */
    protected $formOptions = [];

    /**
     * @var FormInterface
     */
    private $form;


    /**
     * @param EntityManager $em
     * @param FormFactory   $formFactory
     * @param Request       $request
     * @param string        $entityName
     * @param string        $formClassName
     */
    public function __construct(EntityManager $em, FormFactory $formFactory, Request $request, $entityName, $formClassName)
    {
        $this->em = $em;
        $this->entityName = $entityName;
        $this->formClassName = $formClassName;
        $this->repository = $em->getRepository($entityName);
        $this->formFactory = $formFactory;
    }

    /**
     * @return array|Entity[]
     * @throws NotFoundHttpException
     */
    public function getAll()
    {
        $entities = $this->repository->findAll();

        if ($entities === null) {
            throw new NotFoundHttpException('No result found');
        }

        return $entities;
    }

    /**
     * Persist an entity
     *
     * @param Entity $entity
     */
    public function persist( $entity)
    {
        $this->em->persist($entity);
    }

    /**
     * Delete an entity
     *
     * @param Entity $entity
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
    }

    /**
     * Get the entity manager
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Flush the entity manager
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * Create or update an entity
     *
     * @param EntityInterface  $entity
     * @param Request $request
     *
     * @return bool|FormInterface
     */
    public function save(EntityInterface $entity, Request $request)
    {
        $success = false;
        $form = $this->getForm($entity, $this->formOptions);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($entity);
            $success = true;
        } else {
            $this->form = $form;
        }

        return ['success' => $success, 'form' => $form];
    }

    /**
     * @param EntityInterface $entity
     *
     * @return FormInterface
     */
    public function getForm(EntityInterface $entity)
    {
        $form = $this->formFactory->create(new $this->formClassName(), $entity, $this->formOptions);

        return $form;
    }

    /**
     * @param int $id
     *
     * @return null|EntityInterface
     * @throws NotFoundHttpException
     */
    public function getOne($id = null)
    {
        if ($id === null) {
            $className = $this->getEntityClassName();
            $entity = new $className();
        } else {
            $entity = $this->getOneById($id);
        }

        return $entity;
    }

    /**
     * Get the entity class name
     * (the right part of the entity name after the last ':')
     * @return string
     */
    public function getEntityClassName()
    {
        //$metadata = $this->em->getClassMetadata($this->entityName);
        $metadata = $this->em->getMetadataFactory()->getMetadataFor($this->entityName);

        return $metadata->getName();
    }

    /**
     * @throws NotFoundHttpException
     *
     * @param int $id
     *
     * @return null|Entity
     */
    public function getOneById($id)
    {
        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundHttpException('No result found');
        }

        return $entity;
    }

    /**
     * @return array
     */
    public function getFormOptions()
    {
        return $this->formOptions;
    }

    /**
     * @param array $formOptions
     */
    public function setFormOptions($formOptions)
    {
        $this->formOptions = $formOptions;
    }

    /**
     * @return string
     */
    public function getFormClassName()
    {
        return $this->formClassName;
    }

    /**
     * @param string $formClassName
     */
    public function setFormClassName($formClassName)
    {
        $this->formClassName = $formClassName;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }
}