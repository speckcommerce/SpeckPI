<?php

namespace SpeckPI\Mapper;

use SpeckPI\Entity\PerformanceIndicator;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class PIMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setEntityPrototype(new PerformanceIndicator);
        $this->setHydrator(new PIHydrator);
    }

    public function findByItemId($itemId)
    {
        $select = new Select;
        $select->from('cart_item_index');

        $where = new Where;
        $where->equalTo('item_id', $itemId);

        $resultSet = $this->selectMany($select->where($where));
        return $resultSet;
    }

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
          $this->insert($data, 'cart_item_index');
        } catch (\Exception $e) {
            unset($data['item_id']);

            $where = new Where;
            $where->equalTo('item_id', $pi->getItemId());

            $this->update($data, $where, 'cart_item_index');
        }
    }

    protected function selectMany($select)
    {
        $resultSet = $this->selectWith($select);

        $return = array();
        foreach ($resultSet as $r) {
            $return[] = $r;
        }

        return $return;
    }
}
