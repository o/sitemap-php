<?php

namespace Osm\Sitemap;

use XMLWriter;

abstract class AbstractGenerator
{

    const EXTENSION_XML = '.xml';

    const SEPARATOR = '-';

    /**
     * @var XMLWriter
     */
    protected $xmlWriter;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var integer
     */
    protected $maximumUrlCount;

    /**
     * @var integer
     */
    protected $currentUrlCount = 0;

    /**
     * @var integer
     */
    protected $currentFileCount = 0;

    /**
     * AbstractGenerator constructor.
     */
    public function __construct()
    {
        $this->maximumUrlCount = $this->getDefaultMaximumUrlCount();
    }

    abstract protected function getDefaultMaximumUrlCount();

    abstract protected function startXml();

    /**
     * @return int
     */
    public function getMaximumUrlCount()
    {
        return $this->maximumUrlCount;
    }

    /**
     * @param int $maximumUrlCount
     */
    public function setMaximumUrlCount($maximumUrlCount)
    {
        $this->maximumUrlCount = $maximumUrlCount;
    }

    public function getCurrentXmlFileName()
    {
        if ($this->currentFileCount) {
            return $this->directory.DIRECTORY_SEPARATOR.$this->fileName.self::SEPARATOR.$this->currentFileCount.self::EXTENSION_XML;
        }

        return $this->directory.DIRECTORY_SEPARATOR.$this->fileName.self::EXTENSION_XML;
    }

    protected function openXml()
    {
        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openURI($this->getCurrentXmlFileName());
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->xmlWriter->setIndent(true);

        $this->startXml();
    }


    public function closeXml()
    {
        $this->xmlWriter->endElement();
        $this->xmlWriter->endDocument();
    }

    /**
     * @return bool
     */
    protected function shouldANewFileToBeCreated()
    {
        return ($this->currentUrlCount % $this->maximumUrlCount) === 0;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @return int
     */
    public function getCurrentUrlCount()
    {
        return $this->currentUrlCount;
    }

    /**
     * @return int
     */
    public function getCurrentFileCount()
    {
        return $this->currentFileCount;
    }

}