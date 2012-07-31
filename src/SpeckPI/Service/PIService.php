<?php

namespace SpeckPI\Service;

use SpeckCart\Service\CartEvent;

class PIService
{
    protected $piMapper;

    public function postAddItem(CartEvent $e)
    {
        if (!$e->getParam('performance_indicators')) {
            return;
        }

        $indicators = $e->getParam('performance_indicators');

        foreach ($indicators as $i) {
            $i->setItemId($e->getCartItem()->getCartItemId());
            $this->getPIMapper()->persist($i);
        }
    }

    public function findByItem($itemId)
    {
        return $this->getPIMapper()->findByItemId($itemId);
    }

    public function attachDefaultListeners()
    {
        $events = $this->getSharedManager();
    }

    public function getPIMapper()
    {
        return $this->piMapper;
    }

    public function setPIMapper($piMapper)
    {
        $this->piMapper = $piMapper;
        return $this;
    }
}
