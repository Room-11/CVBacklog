<?php namespace com\github\gooh\CVBacklog;
class QueryString implements \ArrayAccess
{
    protected $parts;

    public function __construct(array $parts = array())
    {
        $this->parts = $parts;
    }

    public function offsetSet($offset, $value)
    {
        $this->parts[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        return $this->parts[$offset];
    }

    public function offsetUnset($offset)
    {
        unset($this->parts[$offset]);
    }

    public function offsetExists($offset)
    {
        return isset($this->parts[$offset]);
    }

    public function __toString()
    {
        return http_build_query($this->parts);
    }
}