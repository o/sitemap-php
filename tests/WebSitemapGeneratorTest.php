<?php

namespace Osm\Sitemap;

use PHPUnit\Framework\TestCase;

class WebSitemapGeneratorTest extends TestCase
{
    const XML_FOLDER = __DIR__. '/xmls/';
    const GENERATED_XML_FOLDER = self::XML_FOLDER . 'generated/';

    public function testGetDefaultMaximumUrlCount()
    {
        $g = new WebSitemapGenerator('sitemap.nl');
        $this->assertEquals(50000, $g->getMaximumUrlCount());

        $g->setMaximumUrlCount(100);
        $this->assertEquals(100, $g->getMaximumUrlCount());
    }

    public function testConstructor()
    {
        $g = new WebSitemapGenerator('sitemap.nl');
        $this->assertEquals('sitemap.nl', $g->getBaseUrl());
        $this->assertEquals('./', $g->getDirectory());
        $this->assertEquals('sitemap', $g->getFileName());

        $h = new WebSitemapGenerator('sub.sitemap.de', '/tmp', 'map');
        $this->assertEquals('sub.sitemap.de', $h->getBaseUrl());
        $this->assertEquals('/tmp', $h->getDirectory());
        $this->assertEquals('map', $h->getFileName());
    }

    public function testStartXmlCalledAndFileCreated()
    {
        $filename = 'test-start-xml-called';
        $filenameWithExt = $filename.'.xml';

        $g = new WebSitemapGenerator('sitemap.nl', self::GENERATED_XML_FOLDER, $filename);
        $g->addItem(new WebSitemapItem('/foo'));
        $g->closeXml();

        $this->assertFileExists(self::GENERATED_XML_FOLDER.$filenameWithExt);

        $this->assertXmlFileEqualsXmlFile(
            self::XML_FOLDER.$filenameWithExt,
            self::GENERATED_XML_FOLDER.$filenameWithExt
        );
    }


}
