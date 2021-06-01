<?php
declare(strict_types=1);

namespace Avast\XmlParser\util;

use SimpleXMLElement;

class XmlNode {

    private $name;
    private $value;
    private $attributes;


    public function __construct($xmlObject)
    {

        $this->name = $xmlObject->getName();
        $this->attributes = $xmlObject->attributes();

        if ($xmlObject->count()) {
            $this->value = $this->xmlToArray($xmlObject);
        } else {
            $this->value = $xmlObject->__toString();
        }
    }

    public function getAttributes()
    {
        $attr = '';
        foreach($this->attributes as $value) {
            $attr .= ':'.$value;
        }
        return $this->getName().$attr;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    private function xmlToArray(SimpleXMLElement $xmlObject): array
    {
        $out = [];
        foreach ((array) $xmlObject as $index => $node) {
            if (is_object($node)) {
                $this->xmlToArray($node);
            } else {
                $out[$index] = $node;
            }
        }

        return $out;
    }
}