<?php namespace com\github\gooh\CVBacklog;
class JsonBacklogView
{
    /**
     * @var array
     */
    protected $backlog;

    /**
     * @param array $backlog
     */
    public function __construct(array $backlog)
    {
        $this->backlog = $backlog;
    }

    /**
     * @return string
     */
    public function render()
    {
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($this->backlog);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}