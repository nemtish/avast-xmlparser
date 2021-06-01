<?php
declare(strict_types=1);

namespace Avast\XmlParser\util;

use Predis\Client;

class RedisService {

    protected Client $redis;

    /**
     * Setup redis client
     * with config
     */
    public function __construct(array $config = [])
    {
        $redis = new Client($config);
        $redis->connect();
        $this->redis = $redis;
    }

    public function set(XmlNode $node): void
    {
        $redisKey = $node->getAttributes();
        $redisValue = json_encode($node->getValue());
        $this->redis->set($redisKey, $redisValue);
    }

    public function get($key): mixed
    {
        return json_decode($this->redis->get($key));
    }

    public function getAll(): array
    {
        return $this->redis->keys("*");
    }
}