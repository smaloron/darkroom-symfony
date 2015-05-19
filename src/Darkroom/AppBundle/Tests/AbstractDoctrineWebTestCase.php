<?php

namespace Darkroom\AppBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * This abstract class provides helper for functional tests
 *
 * Class AbstractDoctrineWebTestCase
 * @package Darkroom\AppBundle\Tests
 */
class AbstractDoctrineWebTestCase extends WebTestCase
{
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
     * get the entity manager and client on setup
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client = $this->createClient();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

}