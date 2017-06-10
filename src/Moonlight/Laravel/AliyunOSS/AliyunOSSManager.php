<?php

namespace Moonlight\Laravel\AliyunOSS;

use InvalidArgumentException;
use OSS\OssClient;


class AliyunOSSManager
{
    /**
     * The Aliyun OSS configurations.
     *
     * @var array
     */
    protected $config;

    /**
     * The OSS adapters.
     *
     * @var
     */
    protected $adapters;

    /**
     * Create a new OSS manager instance.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get a OSS adapter by name.
     *
     * @param string|null $name
     *
     * @return AliyunOSSAdapter
     */
    public function adapter($name = null)
    {
        $name = $name ?: 'oss';

        if (isset($this->adapters[$name])) {
            return $this->adapters[$name];
        }

        return $this->adapters[$name] = $this->resolve($name);
    }

    /**
     * Resolve the given adapter by name.
     *
     * @param string $name
     *
     * @return AliyunOSSAdapter
     */
    protected function resolve($name)
    {
        if (!isset($this->config[$name])) {
            throw new InvalidArgumentException("OSS adapter [{$name}] not configured.");
        }

        // retrieve the configuration
        $config = $this->config[$name];

        $accessId = $config['access_id'];
        $accessKey = $config['access_key'];
        $endPoint = $config['endpoint'];
        $bucket = $config['bucket'];

        $client = new OssClient($accessId, $accessKey, $endPoint);
        $adapter = new AliyunOSSAdapter($client, $bucket);

        return $adapter;
    }

    /**
     * Pass methods onto the default OSS adapter.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->adapter()->{$method}(...$parameters);
    }
}
