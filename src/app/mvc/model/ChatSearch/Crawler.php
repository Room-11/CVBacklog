<?php namespace com\github\gooh\CVBacklog;
class Crawler
{
    /**
     * @var Webpage
     */
    protected $webpage;

    /**
     * @var integer
     */
    protected $maxScrapes = 25;

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
        $maxScrapes = $this->maxScrapes;
        do {
            $this->webpage->setUrlToNextPage();
            $links = $this->scrapeCurrentUrlForQuestionIds();
            $allLinks = array_merge($allLinks, $links);
        } while (
            --$maxScrapes !== 0 && !empty($links)
        );
        return array_unique($allLinks);
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