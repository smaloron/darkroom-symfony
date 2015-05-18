<?php

namespace Darkroom\ModelBundle\EntityManager;

/**
 * Interface EntityManagerInterface
 * @package Darkroom\ModelBundle\EntityManager
 */
interface EntityManagerInterface
{
    public function getAll();

    public function getOneById($id);

    public function deleteById($id);

    public function persist($entity);

    public function getRepository();

    public function getEntityManager();

    public function getEntityName();

    public function flush();
}