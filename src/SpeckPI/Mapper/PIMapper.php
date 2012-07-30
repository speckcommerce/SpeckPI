<?php

namespace SpeckPI\Mapper;

use SpeckPI\Entity\PerformanceIndicator;

class PIMapper
{
    public function persist(PerformanceIndicator $pi)
    {
        $data = array(
            'item_id' => $pi->getItemId(),
            'key'     => $pi->getKey()
        );

        if ($pi->getType() === PerformanceIndicator::TYPE_INT) {
            $data['value_int']    = $pi->getValue();
            $data['value_string'] = null;
        } else {
            $data['value_int']    = null;
            $data['value_string'] = $pi->getValue();
        }

        try {
            $this->insert('cart_item_index', $data);
        } catch (\Exception $e) {
            unset($data['item_id']);

            $where = new Where;
            $where->equalTo('item_id', $pi->getItemId());

            $this->update('cart_item_index', $where, $data);
        }
    }
}
