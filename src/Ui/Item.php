<?php

namespace Pyro\MenusModule\Ui;

use BadMethodCallException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @property-read \Pyro\MenusModule\Ui\ItemCollection|\Pyro\MenusModule\Ui\Item[] $children
 */
class Item implements \ArrayAccess, Arrayable, Jsonable, \JsonSerializable
{
    protected $data = [];

    /**
     * PDOFetchClass constructor.
     *
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        if (is_object($data)) {
            $data = (array)$data;
        }
        $data       = Arr::wrap($data);
        $this->data = $data;
        if (isset($data[ 'children' ])) {
            unset($data[ 'children' ]);
        }
        $this->data[ 'children' ] = new ItemCollection();
    }

    public function get($name, $default = null)
    {
        return data_get($this->data, $name, $default);
    }

    public function set($name, $value)
    {
        data_set($this->data, $name, $value);
        return $this;
    }

    public function has($keys)
    {
        Arr::has($this->data, $keys);
        return $this;
    }

    public function forget($keys)
    {
        Arr::forget($this->data, $keys);
        return $this;
    }

    public function hasChildren()
    {
        return isset($this->data[ 'children' ]) && $this->data[ 'children' ]->count() > 0;
    }

    public function __call($name, $arguments)
    {
        $collection = $this->collect();
        if (method_exists($collection, $name)) {
            return call_user_func_array([ $collection, $name ], $arguments);
        }
        throw new BadMethodCallException("Method $name does not exist");
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }

    public function __unset($name)
    {
        return $this->forget($name);
    }

    public function offsetExists($name)
    {
        return $this->has($name);
    }

    public function offsetGet($name)
    {
        return $this->get($name);
    }

    public function offsetSet($name, $value)
    {
        $this->set($name, $value);
    }

    public function offsetUnset($name)
    {
        return $this->forget($name);
    }

    public function dump()
    {
        return VarDumper::dump($this->data);
    }

    public function collect()
    {
        return collect($this->data);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->collect()->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
