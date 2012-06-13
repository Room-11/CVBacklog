<?php namespace com\github\gooh\CVBacklog;
class BacklogView
{
    /**
     * @var array
     */
    protected $backlog;

    /**
     * @var string
     */
    protected $template = '/templates/backlog.xhtml';

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
        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->load(__DIR__ . $this->template);
        $backlog = $dom->getElementById('backlog');
        $backlog->parentNode->replaceChild(
            $this->createXhtmlItemList($dom),
            $backlog
        );
        $dom->formatOutput = true;
        return $dom->saveXML($dom->documentElement);
    }

    /**
     * @param \DOMDocument $dom
     * @return \DOMElement
     */
    protected function createXhtmlItemList(\DOMDocument $dom)
    {
        $ul = $dom->createElement('ul');
        foreach ($this->backlog as $item) {
            $ul->appendChild($dom->createElement('li'))
                ->appendChild($dom->createElement('a', $item->title))
                    ->setAttribute('class', isset($item->closed_date) ? 'delv' : 'cv')
                    ->parentNode
                    ->setAttribute('href', $item->link)
                    ->parentNode
                    ->setAttribute('title', $item->title);
        }
        return $ul;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}