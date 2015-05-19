<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ManufacturerControllerTest
 * @package Darkroom\AppBundle\Tests\Controller\Chemistry
 */
class ManufacturerControllerTest extends AbstractDoctrineWebTestCase
{

    /**
     * Show the list of manufacturer
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/chemistry/manufacturer/');

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("Ilford")')->count() > 0,
            'The name Ilford does not appear'
        );
    }

    /**
     * Create a new Manufacturer
     */
    public function testCreate()
    {
        $crawler = $this->client->request('GET', '/chemistry/manufacturer/');

        $form = $crawler->filter('form')->form(
            array (
                'darkroom_modelbundle_manufacturer[name]' => 'custom manufacturer',
            )
        );

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("custom manufacturer")')->count() > 0,
            'The custom manufacturer does not appear'
        );
    }

    /**
     * Update a unit category
     */
    public function testUpdate()
    {
        /**
         * @var EntityRepository
         */
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\Manufacturer');
        $unitCategory = $repository->findOneByName('custom manufacturer');
        $id = $unitCategory->getId();

        $crawler = $this->client->request('GET', '/chemistry/manufacturer/' . $id);

        $form = $crawler->filter('form')->form(
            array (
                'darkroom_modelbundle_manufacturer[name]' => 'updated custom manufacturer',
            )
        );

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("updated custom manufacturer")')->count() > 0,
            'The updated custom manufacturer does not appear'
        );
    }

    /**
     * Delete a unit category
     */
    public function testDelete()
    {
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\Manufacturer');
        $unitCategory = $repository->findOneByName('updated custom manufacturer');
        $id = $unitCategory->getId();

        $crawler = $this->client->request('GET', '/chemistry/manufacturer/delete/' . $id);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("updated custom manufacturer")')->count() == 0,
            'The updated custom manufacturer still appears'
        );
    }
}
