<?php namespace com\github\gooh\CVBacklog;

class BacklogController implements RequestHandler
{
    protected $backlog;
    protected $mirror;

    public function __construct($backlog, Url $mirror = null)
    {
        $this->backlog = $backlog;
        $this->mirror = $mirror;
    }

    public function handleRequest()
    {
        try {
            return $this->isJsonRequest()
                ? new JsonBacklogView($this->backlog->findAll())
                : new BacklogView($this->backlog->findAll());
        } catch (ThrottleViolation $e) {
            if ($this->mirror instanceof Url) {
                header("Location: {$this->mirror}", 302);
                return "Redirecting to Mirror.";
            }
            return "This CVBacklog is currently unavailable";
        }
    }

    protected function isJsonRequest()
    {
        return strpos($_SERVER['HTTP_ACCEPT'], 'application/json') === 0;
    }
}