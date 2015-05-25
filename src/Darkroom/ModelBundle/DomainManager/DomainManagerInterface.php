<?php

namespace Darkroom\ModelBundle\DomainManager;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;

/**
 * Interface DomainManagerInterface
 * @package Darkroom\ModelBundle\DomainManager
 */
interface DomainManagerInterface
{
    public function getAll();

    public function getOneById($id);

    public function deleteById($id);

    public function persist(DarkroomEntityInterface $entity, $components = null);

    public function getRepository();

    public function getEntityManager();

    public function getEntityName();

    public function flush();
}