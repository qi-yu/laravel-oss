<?php

namespace Moonlight\Laravel\AliyunOSS\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @see AliyunOssManager
 */
class OSS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'oss';
    }
}