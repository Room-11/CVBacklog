<?php namespace com\github\gooh\CVBacklog;
class Questions extends Url
{
    /**
     * @var string
     */
    protected $siteUrl = 'https://api.stackexchange.com/2.0/questions/%s';

    /**
     * @var QueryString
     */
    protected $query = array(
        'site' => 'stackoverflow',
        'filter' => '!3wg4GAnWbdQ5i*Hm.',
        'pagesize' => 100,
        'order' => 'desc',
        'sort' => 'creation'
    );

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct($this->siteUrl);
        $this->setQuery(new QueryString($this->query));
    }
}