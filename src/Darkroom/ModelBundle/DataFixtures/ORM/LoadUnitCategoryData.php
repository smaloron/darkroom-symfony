<?php

namespace Darkroom\ModelBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;

class LoadUnitCategoryData extends DataFixtureLoader
{
    protected function getFixtures(){
        return array(
            __DIR__.'/fixtures-data/unit-category.yml',
            __DIR__.'/fixtures-data/unit.yml',
            __DIR__.'/fixtures-data/manufacturer.yml',
            __DIR__.'/fixtures-data/recipe-category.yml',
            __DIR__.'/fixtures-data/chemical-product.yml',
            __DIR__.'/fixtures-data/chemical-recipe.yml',
            __DIR__ . '/fixtures-data/solution-container.yml',
            __DIR__ . '/fixtures-data/chemical-solution.yml',

        );
    }
}