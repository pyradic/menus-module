<?php

namespace Pyro\MenusModule\Http\Controller\Admin;

use Crvs\Platform\Asset\Asset;

class AjaxAsset extends Asset
{
    protected $RADIC = true;


    public function publishTo($collection, $filename, $filters = [])
    {
        $outputPath = $this->paths->outputPath($collection);
        $path       = path_join(path_get_directory($outputPath), $filename);
        $this->publish($path, $collection, $filters);
        return $path;
    }

    public function has($collection)
    {
        return array_key_exists($collection, $this->collections);
    }
}
