<?php

namespace Darkroom\ModelBundle\DomainManager;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This class is a wrapper around the Doctrine entity manager and the doctrine repository
 * It exposes basics methods to manage entities and should be extended to add specifics
 * It is not abstract since it is used in services to provides
 * basic functionality for simple crud operations
 *
 * Class DefaultDomainManager
 * @package Darkroom\ModelBundle\DomainManager
 */
class DefaultDomainManager implements DomainManagerInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @param EntityManager $entityManager
     * @param $entityName
     */
    public function __construct(EntityManager $entityManager, $entityName)
    {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
        $this->repository = $this->entityManager->getRepository($this->entityName);
    }

    /**
     *
     * @return array
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
     * @param int $id
     */
    public function deleteById($id)
    {
        $entity = $this->getOneById($id);
        $this->entityManager->remove($entity);
    }

    /**
     * @param $id
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
     * @param $entity
     */
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
    }

    /**
     * @param DarkroomEntityInterface $entity
     * @param array $components
     */
    public function persist(DarkroomEntityInterface $entity, array $components = null)
    {
        $this->entityManager->persist($entity);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getEntityName()
    {
        return $this->entityName;
    }



}