<?php
declare(strict_types=1);

namespace Avast\XmlParser\util;

use Exception;
use SimpleXMLElement;

class XmlParser {

    private $xml;
    private $current;

    public function __construct($xmlFilePath)
    {
        if (!file_exists($xmlFilePath)) throw new Exception('File path is not correct');

        $xml = simplexml_load_file($xmlFilePath);
        $this->xml = $xml;
    }

    /**
     * Search for xml node by key
     * @param keyName
     * @example parent:child
     */
    public function findKey(string $keyName): self
    {
        $keys = explode(':', $keyName);

        $node = null;
        foreach ($keys as $key) {
            if (is_null($node)) {
                $node = $this->xml->{$key};
            } else {
                $node = $node->{$key};
            }
        }

        if ($node) {
            $this->current = $node;
        }

        return $this;
    }

    public function get(): SimpleXMLElement
    {
        return $this->current;
    }


    /**
     * Callback is called on each child from current node
     * with XmlNode object as argument
     * @param callable
     */
    public function parse($callable): void
    {
        foreach ($this->current as $node) {
            $callable(new XmlNode($node));
        }
    }

    /**
     * Parse node as array
     * @param callable
     * @param options [name - overrides node name]
     */
    public function parseArray($callable, $options): void
    {
        $xmlNode = new XmlNode($this->current);

        if (array_key_exists('name', $options)) {
            $xmlNode->setName($options['name']);
        }

        $callable($xmlNode);
    }
}