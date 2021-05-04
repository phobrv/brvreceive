<?php

namespace Phobrv\BrvReceive\Facades;

use Illuminate\Support\Facades\Facade;

class BrvReceive extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'brvreceive';
    }
}
