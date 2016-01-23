<?php

namespace netrivet\milestones;

use Github\HttpClient\Cache\CacheInterface;
use Guzzle\Http\Message\Response;

class TransientCache implements CacheInterface
{
    /**
     * @var string
     */
    const TRANSIENT_PREFIX = 'ms_';

    /**
     * @param string $id The id of the cached resource
     *
     * @return bool if present
     */
    public function has($id)
    {
        $transient = $this->fetch($id);
        return $transient !== false;
    }

    /**
     * @param string $id The id of the cached resource
     *
     * @return null|int The modified since timestamp
     */
    public function getModifiedSince($id)
    {
        if ($mtime = $this->fetch("{$id}_mtime")) {
            return $mtime;
        }
    }

    /**
     * @param string $id The id of the cached resource
     *
     * @return null|string The ETag value
     */
    public function getETag($id)
    {
        $tag = $this->fetch("{$id}_etag");
        if ($tag !== false) {
            return $tag;
        }
    }

    /**
     * @param string $id The id of the cached resource
     *
     * @throws \InvalidArgumentException If cache data don't exists
     *
     * @return Response The cached response object
     */
    public function get($id)
    {
        $data = $this->fetch($id);
        return unserialize($data);
    }

    /**
     * @param string $id The id of the cached resource
     * @param Response $response The response to cache
     *
     * @throws \InvalidArgumentException If cache data cannot be saved
     */
    public function set($id, Response $response)
    {
        if (false === $this->cache("{$id}_mtime", time())) {
            throw new \InvalidArgumentException("Could not store resource modified time");
        }

        if (false === $this->cache($id, serialize($response))) {
            throw new \InvalidArgumentException("Could not cache $id in transient");
        }

        $etag = (string) $response->getHeader('ETag');
        if (false === $this->cache("{$id}_etag", $etag)) {
            throw new \InvalidArgumentException("Could not cache etag for $id in transient");
        }
    }

    /**
     * Cache a value in a WordPress transient
     *
     * @param string $id
     * @param string $value
     * @return bool
     */
    protected function cache($id, $value)
    {
        if ($this->fetch($id) === $value) {
            return true;
        }

        $id = $this->key($id);
        $ttl = DAY_IN_SECONDS;
        return set_transient($id, $value, intval($ttl));
    }

    /**
     * Fethch a transient value
     *
     * @param $id
     * @return mixed
     */
    protected function fetch($id)
    {
        $id = $this->key($id);
        return get_transient($id);
    }

    /**
     * Get a key fit for use in transients
     *
     * @param string $id
     * @return string
     */
    protected function key($id)
    {
        return static::TRANSIENT_PREFIX . md5($id);
    }
}
