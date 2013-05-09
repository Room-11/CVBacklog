<?php namespace com\github\gooh\CVBacklog;

/**
 * This is a Sorting Decorator for the Backlog Object
 */
class SortByClosedDate
{
    /**
     * @var Backlog
     */
    private $backlog;

    /**
     * @param Backlog $backlog
     */
    public function __construct(Backlog $backlog)
    {
        $this->backlog = $backlog;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $backlog = $this->backlog->findAll();
        usort($backlog, function($item1, $item2) {
            return isset($item1->closed_date) - isset($item2->closed_date);
        });
        return $backlog;
    }
}