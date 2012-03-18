<?php namespace com\github\gooh\CVBacklog;

class BacklogController implements RequestHandler
{
    public function handleRequest()
    {
        $backlog = new Backlog(
            new Crawler(new Webpage),
            new Client(new Questions)
        );
        return new BacklogView($backlog->findAll());
    }
}