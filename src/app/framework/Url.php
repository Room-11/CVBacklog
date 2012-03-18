<?php namespace com\github\gooh\CVBacklog;
class Url
{
    protected $scheme;
    protected $host;
    protected $port;
    protected $user;
    protected $pass;
    protected $path;
    protected $query;
    protected $fragment;

    /**
     * @param string $url
     * @throws \InvalidArgumentException When $url is invalid
     * @return void
     */
    public function __construct($url = false)
    {
        if ($url) $this->parseUrl($url);
    }

    /**
     * @param string $url
     * @throws \InvalidArgumentException When $url is invalid
     * @return void
     */
    protected function parseUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL: ' . $url);
        }
        foreach (parse_url($url) as $part => $value) {
            $this->$part = $value;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s://%s%s%s%s%s%s',
            $this->scheme,
            $this->user ? (
                $this->pass ? "{$this->user}:{$this->pass}@" : "{$this->user}@"
            ) : '',
            $this->host,
            $this->port ? ':' . $this->port : '',
            $this->path ? $this->path : '',
            $this->query ? '?' . $this->query : '',
            $this->fragment ? '#' . $this->fragment : ''
       );
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
    }
}