<?php namespace com\github\gooh\CVBacklog;
class Webpage extends Url
{
    /**
     * @var string
     */
    protected $siteUrl = 'http://chat.stackoverflow.com/search';

    /**
     * @var array
     */
    protected $query = array(
        'q' => 'cv-pls',
        'page' => 0,
        'pagesize' => 100,
        'sort' => 'newest'
    );

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct($this->siteUrl);
        $this->setQuery(new QueryString($this->query));
    }

    /**
     * @return void
     */
    public function setUrlToNextPage()
    {
        $query = $this->getQuery();
        $query['page'] = $query['page'] + 1;
    }
}