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
        );
    }
}