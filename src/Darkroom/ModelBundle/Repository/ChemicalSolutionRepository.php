<?php

namespace Darkroom\ModelBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ChemicalSolutionRepository extends EntityRepository
{


    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getStockSolutions()
    {
        return $this->createQueryBuilder('s')
            ->where('s.stockSolution = 1')
            ->add('orderBy', 's.dateMixed ASC');
    }

}