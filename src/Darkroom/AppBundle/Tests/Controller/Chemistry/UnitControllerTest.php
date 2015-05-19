<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Darkroom\ModelBundle\Entity\Chemistry\UnitCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;

class UnitControllerTest extends AbstractDoctrineWebTestCase
{

    /**
     * Show the list of units
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/chemistry/unit/');

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("gram")')->count() > 0,
            'The name gram does not appear'
        );
    }

    /**
     * Create a new Unit
     */
    public function testCreate()
    {
        $crawler = $this->client->request('GET', '/chemistry/unit/');

        $form = $crawler->filter('form')->form(
            array (
                'darkroom_modelbundle_unit[name]' => 'custom unit',
                'darkroom_modelbundle_unit[abbrev]' => 'custom abbrev',
                'darkroom_modelbundle_unit[conversionRate]' => 100,
                'darkroom_modelbundle_unit[unitCategory]' => $this->getUnitCategory('weight')->getId(),
            )
        );

        $this->client->submit($form);

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );

        $crawler = $this->client->followRedirect();

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("custom unit")')->count() > 0,
            'The custom unit does not appear'
        );
    }

    /**
     * @param $categoryName
     * @return UnitCategory
     */
    private function getUnitCategory($categoryName){
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\UnitCategory');
        $unitCategory = $repository->findOneByName($categoryName);
        return $unitCategory;
    }

    /**
     * Update a unit
     */
    public function testUpdate()
    {
        /**
         * @var EntityRepository
         */
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\Unit');
        $unit = $repository->findOneByName('custom unit');
        $id = $unit->getId();

        $crawler = $this->client->request('GET', '/chemistry/unit/' . $id);

        $form = $crawler->filter('form')->form(
            array (
                'darkroom_modelbundle_unit[name]' => 'updated custom unit',
            )
        );

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("updated custom unit")')->count() > 0,
            'The updated custom unit does not appear'
        );
    }

    /**
     * Delete a unit
     */
    public function testDelete()
    {
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\Unit');
        $unit = $repository->findOneByName('updated custom unit');
        $id = $unit->getId();

        $crawler = $this->client->request('GET', '/chemistry/unit/delete/' . $id);
        $crawler = $this->client->followRedirect();

        $this->assertTrue(
            Response::HTTP_OK === $this->client->getResponse()->getStatusCode(),
            'The response is not successful'
        );
        $this->assertTrue(
            $crawler->filter('td:contains("updated custom unit")')->count() == 0,
            'the updated custom unit still appears'
        );
    }
}
