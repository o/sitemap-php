<?php

namespace Osm\Sitemap;

class WebSitemapGenerator extends AbstractGenerator
{

    const SCHEMA = 'http://www.sitemaps.org/schemas/sitemap/0.9';
    const DEFAULT_DIRECTORY = './';
    const DEFAULT_FILENAME = 'sitemap';

    public function __construct($baseUrl, $directory = self::DEFAULT_DIRECTORY, $fileName = self::DEFAULT_FILENAME)
    {
        parent::__construct();
        $this->baseUrl = $baseUrl;
        $this->directory = $directory;
        $this->fileName = $fileName;
    }

    protected function getDefaultMaximumUrlCount()
    {
        return 50000;
    }

    protected function startXml()
    {
        $this->xmlWriter->startElement('urlset');
        $this->xmlWriter->writeAttribute('xmlns', self::SCHEMA);
    }

    protected function getFormattedLastModifiedDate(\DateTime $dateTime)
    {
        return $dateTime->format(\DateTime::W3C);
    }

    public function addItem(WebSitemapItem $item)
    {
        if ($this->shouldANewFileToBeCreated()) {
            if ($this->currentFileCount) {
                $this->closeXml();
            }
            $this->openXml();
            ++$this->currentFileCount;
        }
        ++$this->currentUrlCount;
        $this->xmlWriter->startElement('url');
        $this->xmlWriter->writeElement('loc', $this->baseUrl.$item->getLocation());

        if ($item->getPriority()) {
            $this->xmlWriter->writeElement('priority', $item->getPriority());
        }

        if ($item->getChangeFrequency()) {
            $this->xmlWriter->writeElement('changefreq', $item->getChangeFrequency());
        }

        if ($item->getLastModified()) {
            $this->xmlWriter->writeElement(
                'lastmod',
                $this->getFormattedLastModifiedDate($item->getLastModified())
            );
        }

        $this->xmlWriter->endElement();

        return $this;
    }


}