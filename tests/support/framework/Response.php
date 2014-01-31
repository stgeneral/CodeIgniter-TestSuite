<?php
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class CIUnit_Response extends Response
{
	protected $_crawler;

	public function crawler()
	{
		if (null == $this->_crawler) {
			$this->_crawler = new Crawler($this->getContent());
		}
		return $this->_crawler;
	}

	public function filter($selector)
	{
		return $this->crawler()->filter($selector);
	}
}