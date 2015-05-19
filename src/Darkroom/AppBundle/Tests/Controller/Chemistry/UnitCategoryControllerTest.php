<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UnitCategoryControllerTest
 * @package Darkroom\AppBundle\Tests\Controller\Chemistry
 */
class UnitCategoryControllerTest extends AbstractDoctrineWebTestCase
{

    /**
     * Show the list of unit's categories
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/chemistry/unit-category/');

        $this->assertTrue(  Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
                            'The response is not successful');
        $this->assertTrue(  $crawler->filter('td:contains("weight")')->count() > 0,
                            'The name weight does not appear');
    }

    /**
     * Create a new Unit category
     */
    public function testCreate(){
        $crawler = $this->client->request('GET','/chemistry/unit-category/');

        $form = $crawler->filter('form')->form(
            array(
                'darkroom_modelbundle_unitCategory[name]' => 'custom category',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(  Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
                            'The response is not successful');
        $this->assertTrue(  $crawler->filter('td:contains("custom category")')->count() > 0,
                            'The custom category does not appear');
    }

    /**
     * Update a unit category
     */
    public function testUpdate(){
        /**
         * @var EntityRepository
         */
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\UnitCategory');
        $unitCategory = $repository->findOneByName('custom category');
        $id = $unitCategory->getId();

        $crawler = $this->client->request('GET','/chemistry/unit-category/'.$id);

        $form = $crawler->filter('form')->form(
            array(
                'darkroom_modelbundle_unitCategory[name]' => 'updated custom category',
            ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(  Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
                            'The response is not successful');
        $this->assertTrue(  $crawler->filter('td:contains("updated custom category")')->count() > 0,
                            'The updated custom category does not appear');
    }

    /**
     * Delete a unit category
     */
    public function testDelete(){
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\UnitCategory');
        $unitCategory = $repository->findOneByName('updated custom category');
        $id = $unitCategory->getId();

        $crawler = $this->client->request('GET','/chemistry/unit-category/delete/'.$id);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(  Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
                            'The response is not successful');
        $this->assertTrue(  $crawler->filter('td:contains("updated custom category")')->count() == 0,
                            'the updated custom category still appears');
    }


}