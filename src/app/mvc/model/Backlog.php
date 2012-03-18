<?php namespace com\github\gooh\CVBacklog;
class Backlog
{
    protected $crawler;
    protected $stackApi;

    public function __construct($crawler, $stackApi) {
        $this->crawler = $crawler;
        $this->stackApi = $stackApi;
    }

    /**
     * @return array:
     */
    public function findAll()
    {
        return $this->stackApi->findByIds(
            $this->crawler->findAllQuestionIds()
        );
    }
}