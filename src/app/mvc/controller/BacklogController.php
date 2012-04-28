<?php namespace com\github\gooh\CVBacklog;

class BacklogController implements RequestHandler
{
    protected $backlog;

    public function __construct($backlog)
    {
        $this->backlog = $backlog;
    }

    public function handleRequest()
    {
        return $this->isJsonRequest()
            ? new JsonBacklogView($this->backlog->findAll())
            : new BacklogView($this->backlog->findAll());
    }

    protected function isJsonRequest()
    {
        return strpos($_SERVER['HTTP_ACCEPT'], 'application/json') === 0;
    }
}