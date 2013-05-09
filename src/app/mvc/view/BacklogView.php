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
        header('Content-Type: text/html; charset=utf-8');
        return $this->renderBacklog();
    }

    public function renderBacklog()
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
		$delvs = $cvs = array();
		
        foreach ($this->backlog as $item) {
				$li = $dom->createElement('li');
                $li->appendChild($dom->createElement('a', $item->title))
                    ->setAttribute('class', isset($item->closed_date) ? 'delv' : 'cv')
                    ->parentNode
                    ->setAttribute('href', $item->link)
                    ->parentNode
                    ->setAttribute('title', $item->title);
				if(isset($item->closed_date))
					$delvs[] = $li;
				else
					$cvs[] = $li;
        }
        $ul = $dom->createElement('ul');
		foreach($cvs as $li)
			$ul->appendChild($li);
		foreach($delvs as $li)
			$ul->appendChild($li);
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
