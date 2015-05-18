<?php

namespace Darkroom\ModelBundle\EntityManager;

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
 * Class DefaultEntityManager
 * @package Darkroom\ModelBundle\EntityManager
 */
class DefaultEntityManager implements EntityManagerInterface
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @param EntityManager $entityManager
     * @param $entityName
     */
    public function __construct(EntityManager $entityManager, $entityName){
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
        $this->repository = $this->entityManager->getRepository($this->entityName);
    }

    /**
     *
     * @return array
     */
    public function getAll(){
        $entities = $this->repository->findAll();

        if ($entities === null) {
            throw new NotFoundHttpException('No result found');
        }

        return $entities;
    }

    /**
     * @param $id
     * @return null|Entity
     */
    public function getOneById($id){
        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundHttpException('No result found');
        }

        return $entity;
    }

    /**
     * @param $id
     */
    public function deleteById($id){
        $entity = $this->getOneById($id);
        $this->entityManager->remove($entity);
    }

    /**
     * @param $entity
     */
    public function persist($entity){
        $this->entityManager->persist($entity);
    }

    public function flush(){
        $this->entityManager->flush();
    }

    public function getRepository(){
        return $this->repository;
    }

    public function getEntityManager(){
        return $this->entityManager;
    }

    public function getEntityName(){
        return $this->entityName;
    }



}