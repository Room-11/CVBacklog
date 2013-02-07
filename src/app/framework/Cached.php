<?php namespace com\github\gooh\CVBacklog;
class Cached
{
    /**
     * @var object
     */
    protected $instance;

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var array
     */
    protected $methods = array();

    /**
     * @param object $instance
     * @param string $cacheDir
     */
    public function __construct($instance, $cacheDir = null)
    {
        $this->instance = $instance;
        $this->cacheDir = $cacheDir === null ? sys_get_temp_dir() : $cacheDir;
    }

    /**
     * @param string $method
     * @param integer $timeToLive
     */
    public function defineCachingForMethod($method, $timeToLive) 
    {
        $this->methods[$method] = $timeToLive;
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($this->hasActiveCacheForMethod($method, $args)) {
            return $this->getCachedMethodCall($method, $args);
        } else {
            return $this->cacheAndReturnMethodCall($method, $args);
        }
    }

    /**
     * @param string $method
     * @param array $args
     */
    protected function hasActiveCacheForMethod($method, $args)
    {
        return isset($this->methods[$method]) && !$this->cacheFileIsStale(
            $this->getCacheFilename($method, $args),
            $this->methods[$method]
        );
    }

    /**
     * @param string $cacheFile
     * @param integer $timeToLive
     * @return boolean
     */
    protected function cacheFileIsStale($cacheFile, $timeToLive)
    {
        if (file_exists($cacheFile)) {
            return filemtime($cacheFile) + $timeToLive < time();
        }
        return true;
    }

    /**
     * @param string $method
     * @param string $args
     * @return string
     */
    protected function getCacheFilename($method, $args)
    {
        return sprintf('%s/%s', $this->cacheDir, $this->hash($method, $args));
    }

    /**
     * @param string $method
     * @param string $args
     * @return string
     */
    protected function hash($method, $args)
    {
        return md5(gettype($this->instance) . $method . serialize($args));
    }

    /**
     * @param string $method
     * @param string $args
     * @return mixed
     */
    protected function getCachedMethodCall($method, $args)
    {
        return unserialize(file_get_contents($this->getCacheFilename($method, $args)));
    }

    /**
     * @param string $method
     * @param string $args
     * @return mixed
     */
    protected function cacheAndReturnMethodCall($method, $args)
    {
        $result = call_user_func_array(array($this->instance, $method), $args);
        $this->writeCache($method, $args, $result);
        return $result;
    }

    /**
     * @param string $method
     * @param string $args
     * @param string $data
     */
    protected function writeCache($method, $args, $data)
    {
        file_put_contents(
            $this->getCacheFilename($method, $args),
            serialize($data)
        );
    }
}
