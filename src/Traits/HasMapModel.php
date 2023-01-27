<?php

namespace mamadali\objectMapping\src\Traits;

use App\Packages\objectMapping\src\Interfaces\ObjectMappingInterface;
use http\Exception\InvalidArgumentException;

trait HasMapModel
{

    public function __construct()
    {
        if(!$this instanceof ObjectMappingInterface){
            throw new InvalidArgumentException(get_class($this) . ' must be implement from mamadali\Interfaces\ObjectMappingInterface');
        }
    }

    /**
     * to use mapData method your class must be implemented from ObjectMapping interface and declared 'mapAttributes' method
     * @param array $data
     * @param string $type
     * @return $this
     */
    public function mapData(array $data, string $type): static
    {
        $mapAttributes = $this->mapAttributes();
        foreach (($data ?? []) as $key => $value) {
            $attribute = array_key_exists($key, $mapAttributes) ? $mapAttributes[$key] : $key;
            $this->{$attribute} = $value;
        }
        return $this;
    }

}
