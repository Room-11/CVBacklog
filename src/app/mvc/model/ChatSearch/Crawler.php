<?php namespace com\github\gooh\CVBacklog;
class Crawler
{
    /**
     * @var Webpage
     */
    protected $webpage;

    /**
     * @return void
     */
    public function __construct(Webpage $chatSearchUrl)
    {
        $this->webpage = $chatSearchUrl;
    }

    /**
     * @return array:
     */
    public function findAllQuestionIds()
    {
        $allLinks = array();
        $noResultsFound = false;
        while (!$noResultsFound) {
            $this->setUrlToNextPage();
            $links = $this->scrapeCurrentUrlForQuestionIds();
            $noResultsFound = empty($links);
            $allLinks = array_merge($allLinks, $links);
        }
        return array_unique($allLinks);
    }

    /**
     * @return void
     */
    protected function setUrlToNextPage()
    {
        $query = $this->webpage->getQuery();
        $query['page'] = $query['page'] + 1;
    }

    /**
     * @return array
     */
    protected function scrapeCurrentUrlForQuestionIds()
    {
        return preg_match_all(
            '(
                http://              # match hyperlinks
                (?:www\.)?           # optionally starting with www
                stackoverflow.com/   # pointing to stackoverflow
                q(?:uestions)?/      # with path q or questions
                (?P<qid>\d+)         # and get the Question ID
            )xiu',
            file_get_contents($this->webpage),
            $matches
        )
        ? $matches['qid']
        : array();
    }
}