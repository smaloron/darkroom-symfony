<?php

namespace Darkroom\AppBundle\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\Entity;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * This abstract class provides helper for functional tests
 * And a simple crud test scenario
 *
 * Class AbstractDoctrineWebTestCase
 * @package Darkroom\AppBundle\Tests
 */
class AbstractDoctrineWebTestCase extends WebTestCase
{
    /**
     * @var string
     */
    protected $baseRoute;

    /**
     * @var array
     */
    protected $postData = array();

    protected $updateData = array();

    /**
     * @var string
     */
    protected $updateValue;

    /**
     * @var string
     */
    protected $insertValue;

    /**
     * @var string
     */
    protected $entityName;

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

    /**
     * Get a form hydrated with data
     *
     * @param Crawler $crawler
     * @param array $data
     * @param string $path
     * @return \Symfony\Component\DomCrawler\Form
     */
    protected function getForm(Crawler $crawler, $data = [], $path='form'){
        $form = $crawler->filter($path)->form($data);
        return $form;
    }

    /**
     * Assert a successful http response
     * @param string|null $message
     */
    protected function assertSuccessfulResponse($message = null){
        if(! isset($message)){
            $message = 'The response is not succesfull';
        }

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            $message
        );
    }

    /**
     * Assert the presence of the test value in a table cell
     * @param Crawler $crawler
     * @param string $value
     */
    protected function assertInTable(Crawler $crawler, $value){
        $this->assertTrue(
            $crawler->filter('td:contains("'.$value.'")')->count() > 0,
            'The value '.$value.' does not appear'
        );
    }

    /**
     * Assert the absence of the test value in a table cell
     * @param Crawler $crawler
     * @param string $value
     */
    protected function assertNotInTable(Crawler $crawler, $value){
        $this->assertTrue(
            $crawler->filter('td:contains("'.$value.'")')->count() == 0,
            'The value '.$value.' still appears'
        );
    }

    /**
     * @param string $name
     * @return Entity
     */
    protected function getEntity($name){
        /**
         * @var EntityRepository
         */
        $repository = $this->em->getRepository($this->entityName);
        $entity = $repository->findOneByName($name);
        return $entity;
    }

    /**
     * Testing the crud functionalities
     */
    public function testCrudScenario(){
        // Try posting data to create a new entity
        $crawler = $this->client->request('GET', $this->baseRoute);
        $form = $this->getForm($crawler, $this->postData);
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSuccessfulResponse();

        //Check if the new entity is there
        $this->assertInTable($crawler, $this->insertValue);

        //Try updating data
        $entityId = $this->getEntity($this->insertValue)->getId();
        $crawler = $this->client->request('GET', $this->baseRoute. $entityId);

        $form = $this->getForm($crawler, $this->updateData);
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSuccessfulResponse();

        //Check if the entity is actually updated
        $this->assertInTable($crawler, $this->updateValue);

        //Try to delete the entity
        $this->client->request('GET', $this->baseRoute. 'delete/'. $entityId);
        $crawler = $this->client->followRedirect();
        //Check if the entity is actually updated
        $this->assertNotInTable($crawler, $this->updateValue);

    }

}