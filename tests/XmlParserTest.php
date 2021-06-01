<?php
declare(strict_types=1);

use Avast\XmlParser\util\XmlNode;
use Avast\XmlParser\util\XmlParser;
use PHPUnit\Framework\TestCase;

final class XmlParserTest extends TestCase {

    public function testExceptionIsThrownWhenWrongFilePath()
    {
        $this->expectException(Exception::class);
        new XmlParser('../config.xml');
    }

    public function testFindKeyWithOneKeyParam()
    {
        $parser = new XmlParser('config.xml');
        $node = $parser->findKey('subdomains')->get();
        $this->assertEquals($node->getName(), 'subdomains');
    }

    public function testFindKeyWithTwoKeyParams()
    {
        $parser = new XmlParser('config.xml');
        $node = $parser->findKey('subdomains:subdomain')->get();
        $this->assertEquals($node->getName(), 'subdomain');
    }

    public function testParseCallbackReturnXmlNode()
    {
        $parser = new XmlParser('config.xml');
        $parser->findKey('subdomains:subdomain')->parse(function($node) {
            $this->assertTrue($node instanceof XmlNode);
        });
    }

    public function testXmlNodeValueIsArray()
    {
        $parser = new XmlParser('config.xml');
        $node = $parser->findKey('subdomains:subdomain')->get();
        $xmlNode = new XmlNode($node);
        $this->assertTrue(is_array($xmlNode->getValue()));
    }

    public function testXmlNodeAttributes()
    {
        $parser = new XmlParser('config.xml');
        $node = $parser->findKey('cookies:cookie')->get();
        $xmlNode = new XmlNode($node[0]);
        $this->assertEquals($xmlNode->getAttributes(), 'cookie:dlp-avast:amazon');
    }
}