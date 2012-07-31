<?php

namespace SpeckPITest\Service;

use Bootstrap;
use PHPUnit_Framework_TestCase;

use SpeckCart\Service\CartEvent;
use SpeckCart\Entity\CartItem;

use SpeckPI\Entity\PerformanceIndicator;

class PIServiceTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->piService = Bootstrap::getServiceManager()->get('SpeckPI\Service\PIService');
        $this->eventManager = Bootstrap::getServiceManager()->get('EventManager');
    }

    public function setUp()
    {
        $this->piService->getPIMapper()->getDbAdapter()->query('TRUNCATE cart_item', 'execute');
        $this->piService->getPIMapper()->getDbAdapter()->query('TRUNCATE cart_item_index', 'execute');
    }

    public function testPostAddItem()
    {
        $item = new CartItem;
        $item->setCartItemId(1);

        $event = new CartEvent;
        $event->setCartItem($item);

        $pi1 = new PerformanceIndicator('product_id', 5, PerformanceIndicator::TYPE_INT);
        $pi2 = new PerformanceIndicator('revision_id', 'a');

        $pis = array($pi1, $pi2);

        $event->setParam('performance_indicators', $pis);
        $this->piService->postAddItem($event);

        $pis = $this->piService->findByItem(1);
        $this->assertEquals(2, count($pis));

        $pi = $pis[0];
        $this->assertEquals(1, $pi->getItemId());
        $this->assertEquals('product_id', $pi->getKey());
        $this->assertEquals(5, $pi->getValue());
        $this->assertTrue(is_int($pi->getValue()));
        $this->assertEquals(PerformanceIndicator::TYPE_INT, $pi->getType());

        $pi = $pis[1];
        $this->assertEquals(1, $pi->getItemId());
        $this->assertEquals('revision_id', $pi->getKey());
        $this->assertEquals('a', $pi->getValue());
        $this->assertEquals(PerformanceIndicator::TYPE_STRING, $pi->getType());
    }
}
