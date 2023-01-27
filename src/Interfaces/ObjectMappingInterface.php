<?php

namespace mamadali\ObjectMapping\Interfaces;

/**
 * Object Mapping interface
 *
 */
interface ObjectMappingInterface
{

    /**
     * map api attributes to model attributes
     * example :
     * return [
     *      'title' => 'name',
     *  ];
     *
     * This code map the title attribute in the api to the name attribute in the model
     *
     * @return array
     */
    public function mapAttributes() : array;
}
