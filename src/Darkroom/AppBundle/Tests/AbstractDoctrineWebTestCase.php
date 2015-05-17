<?php

namespace Darkroom\AppBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractDoctrineWebTestCase extends WebTestCase{
    /**
     * helper to acccess EntityManager
     * @var EntityManager
     */
    protected $em;

    /**
     * Helper to access test Client
     * @var Client
     */
    protected $client;

    /**
     * Before each test we start a new transaction
     * everything done in the test will be canceled ensuring isolation et speed
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client = $this->createClient();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        //$this->em->beginTransaction();
    }

    /**
     * After each test, a rollback reset the state of
     * the database
     */
    protected function tearDown()
    {
        parent::tearDown();
        //$this->em->rollback();
        //$this->em->close();


    }
}