<?php
class SitemapPHP
{
	
	private $writer;
	private $domain;
	const INDENT = 4;
	const SCHEMA = 'http://www.sitemaps.org/schemas/sitemap/0.9';
	const DEFAULT_PRIOTORY = 0.5;

	function __construct($domain) {
		$this->setDomain($domain);
		$this->writer = new XMLWriter();
		$this->writer->openURI('php://output'); 
		$this->writer->startDocument('1.0', 'UTF-8'); 
		$this->writer->setIndent(self::INDENT); 
		$this->writer->startElement('urlset'); 
		$this->writer->writeAttribute('xmlns', self::SCHEMA);
	}
	
	/**
	 * Sets the root path of sitemap
	 *
	 * @param string $domain Root path of the website, starting with http://
	 * @return void
	 * @author Osman Ungur
	 */
	private function setDomain($domain)
	{
		$this->domain = $domain;
	}

	/**
	 * Gets the root path of sitemap
	 *
	 * @return string Returns the root path of sitemap
	 * @author Osman Ungur
	 */
	private function getDomain()
	{
		return $this->domain;
	}
	
	/**
	 * Send the xml header to browser
	 *
	 * @return void
	 * @author Osman Ungur
	 */
	private function sendHeader()
	{
		header("Content-type: text/xml");
	}
	
	/**
	 * Adds an item to sitemap
	 *
	 * @param string $loc URL of the page. This value must be less than 2,048 characters. 
	 * @param string $priotory The priority of this URL relative to other URLs on your site. Valid values range from 0.0 to 1.0.
	 * @param string $changefreq How frequently the page is likely to change. Valid values are always, hourly, daily, weekly, monthly, yearly and never.
	 * @param string $lastmod The date of last modification of url. Unix timestamp or any English textual datetime description.. 
	 * @return void
	 * @author Osman Ungur
	 */
	public function addItem($loc, $priotory = self::DEFAULT_PRIOTORY, $changefreq = NULL, $lastmod = NULL)
	{
		$this->writer->startElement('url');
		$this->writer->writeElement('loc', $this->getDomain() . $loc);
		if ($priotory)    $this->writer->writeElement('priotory', (float) $priotory);
		if ($changefreq)  $this->writer->writeElement('changefreq', $changefreq);
		if ($lastmod)     $this->writer->writeElement('lastmod', $this->getLastModifiedDate($lastmod));
		$this->writer->endElement();
	}

	/**
	 * Prepares given date for sitemap
	 *
	 * @param string $date Unix timestamp or any English textual datetime description
	 * @return string Year-Month-Day formatted date.
	 * @author Osman Ungur
	 */
	private function getLastModifiedDate($date)
	{
		if (!ctype_digit($date)) {
			$date = strtotime($date);
			return date('Y-m-d', $date);
		}
		else {
			return date('Y-m-d', $date);
		}
	}
	
	/**
	 * Sends the prepared sitemap to browser.
	 *
	 * @return void
	 * @author Osman Ungur
	 */
	public function render()
	{
		$this->writer->endElement();
		$this->writer->endDocument();
		$this*>sendHeader();
		$this->writer->flush();
	}
}