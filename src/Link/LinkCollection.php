<?php namespace Pyro\MenusModule\Link;

use Anomaly\Streams\Platform\Entry\EntryCollection;
use Pyro\MenusModule\Link\Contract\LinkInterface;

/**
 * \Pyro\MenusModule\Link\LinkCollection
 *
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] filterBy($key, $value) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereLike($key, $values) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] load($relations) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] loadCount($relations) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] loadMissing($relations) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] loadMorph($relation, $relations) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] contains($key, $operator = NULL, $value = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] merge($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] map(callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] diff($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] intersect($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] unique($key = NULL, $strict = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] only($keys) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] except($keys) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] makeHidden($attributes) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] makeVisible($attributes) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] getDictionary($items = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] zip($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] collapse() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] flatten($depth = INF) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] flip() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] times($number, callable $callback = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] all() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] containsStrict($key, $value = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] crossJoin($lists) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] diffUsing($items, callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] diffAssoc($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] diffAssocUsing($items, callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] diffKeys($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] diffKeysUsing($items, callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] duplicates($callback = NULL, $strict = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] duplicatesStrict($callback = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] each(callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] eachSpread(callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] every($key, $operator = NULL, $value = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] filter(callable $callback = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] when($value, callable $callback, callable $default = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whenEmpty(callable $callback, callable $default = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whenNotEmpty(callable $callback, callable $default = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] unless($value, callable $callback, callable $default = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] unlessEmpty(callable $callback, callable $default = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] unlessNotEmpty(callable $callback, callable $default = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] where($key, $operator = NULL, $value = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereStrict($key, $value) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereIn($key, $values, $strict = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereInStrict($key, $values) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereBetween($key, $values) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereNotBetween($key, $values) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereNotIn($key, $values, $strict = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereNotInStrict($key, $values) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] whereInstanceOf($type) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] forget($keys) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] groupBy($groupBy, $preserveKeys = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] keyBy($keyBy) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] intersectByKeys($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] join($glue, $finalGlue = '') 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] mapWithKeys(callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] flatMap(callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] mapInto($class) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] mergeRecursive($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] combine($values) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] union($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] prepend($value, $key = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] push($value) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] concat($source) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] put($key, $value) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] random($number = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] reduce(callable $callback, $initial = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] reject($callback = true) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] replace($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] replaceRecursive($items) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] reverse() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] search($value, $strict = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] shuffle($seed = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] chunk($size) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sort(callable $callback = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sortBy($callback, $options = SORT_REGULAR, $descending = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sortByDesc($callback, $options = SORT_REGULAR) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sortKeys($options = SORT_REGULAR, $descending = false) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sortKeysDesc($options = SORT_REGULAR) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] sum($callback = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] transform(callable $callback) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] uniqueStrict($key = NULL) 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] values() 
 * @method \Pyro\MenusModule\Link\LinkCollection|\Pyro\MenusModule\Link\Contract\LinkInterface[] add($item) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface findBy($key, $value) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface find($key, $default = NULL) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface get($key, $default = NULL) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface firstWhere($key, $operator = NULL, $value = NULL) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface first(callable $callback = NULL, $default = NULL) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface last(callable $callback = NULL, $default = NULL) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface pull($key, $default = NULL) 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface shift() 
 * @method \Pyro\MenusModule\Link\Contract\LinkInterface pop() 
 */
class LinkCollection extends EntryCollection
{
    /**
     * Alias for $this->top()
     *
     * @return LinkCollection
     */
    public function root()
    {
        return $this->top();
    }

    /**
     * Return only top level links.
     *
     * @return LinkCollection
     */
    public function top()
    {
        return $this->filter(
            function ($item) {

                /* @var LinkInterface $item */
                return !$item->getParentId();
            }
        );
    }

    /**
     * Return only enabled links.
     *
     * @return LinkCollection
     */
    public function enabled()
    {
        return $this->filter(
            function ($item) {

                /* @var LinkInterface $item */
                return $item->isEnabled();
            }
        );
    }

    /**
     * Return only children of the provided item.
     *
     * @param $parent
     * @return LinkCollection|null
     */
    public function children($parent)
    {
        if (!$parent) {
            return null;
        }

        /* @var LinkInterface $parent */
        return $this->filter(
            function ($item) use ($parent) {

                /* @var LinkInterface $item */
                return $item->getParentId() == $parent->getId();
            }
        );
    }

    /**
     * Return the current link.
     *
     * @return LinkInterface|null
     */
    public function current()
    {
        /* @var LinkInterface $item */
        foreach ($this->items as $item) {

            if ($item->isCurrent()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return the current link's children.
     *
     * @param null|LinkInterface $link
     * @return LinkCollection|null
     */
    public function siblings($link = null)
    {
        if (!$link) {
            $link = $this->current();
        }

        if (!$link) {
            return null;
        }

        if (!$parent = $link->getParent()) {
            return $this->root();
        }

        return $this->children($parent);
    }

    /**
     * Return only active links.
     *
     * @param  bool $active
     * @return LinkCollection
     */
    public function active($active = true)
    {
        return $this->filter(
            function ($item) use ($active) {

                /* @var LinkInterface $item */
                return $item->isActive() == $active;
            }
        );
    }
}
