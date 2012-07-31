<?php

namespace SpeckPI\Mapper;

use SpeckPI\Entity\PerformanceIndicator;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PIHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $result = array(
            'item_id'      => $object->getItemId(),
            'key'          => $object->getKey(),
            'value_int'    => is_int($object->getValue()) ? $object->getValue() : null,
            'value_string' => is_int($object->getValue()) ? null : $object->getValue(),
        );

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setItemId($data['item_id'])
            ->setKey($data['key']);

        if ($data['value_int'] !== null) {
            $object->setValue(intval($data['value_int']));
            $object->setType(PerformanceIndicator::TYPE_INT);
        } else {
            $object->setValue($data['value_string']);
            $object->setType(PerformanceIndicator::TYPE_STRING);
        }

        return $object;
    }
}
