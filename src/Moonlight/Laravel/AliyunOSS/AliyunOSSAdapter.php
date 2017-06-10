<?php

namespace Moonlight\Laravel\AliyunOSS;

use BadFunctionCallException;
use OSS\OSSClient;


class AliyunOSSAdapter
{
    /**
     * The OSS client.
     *
     * @var OSSClient
     */
    protected $client;

    /**
     * The OSS bucket.
     *
     * @var string
     */
    protected $bucket;

    /**
     * Create a new OSS adapter instance.
     *
     * @param OSSClient $client
     * @param string $bucket
     */
    public function __construct(OSSClient $client, string $bucket)
    {
        $this->client = $client;
        $this->bucket = $bucket;
    }

    /**
     * Get current bucket name.
     *
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Pass other method calls down to the OSS client.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // `listBuckets` is out of the current bucket
        if ($method === 'listBuckets') {
            throw new BadFunctionCallException('listBuckets was not allowed to call.');
        }
        // bucket parameter alwasy at the first position
        array_unshift($parameters, $this->bucket);

        return $this->client->{$method}(...$parameters);
    }
}
