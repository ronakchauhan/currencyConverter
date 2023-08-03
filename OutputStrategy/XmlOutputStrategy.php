<?php

require_once "OutputStrategyInterface.php";

/**
 * XmlOutputStrategy implements the OutputStrategyInterface to convert data to XML format.
 */
class XmlOutputStrategy implements OutputStrategyInterface
{

    /**
     * Converts an array of data to XML format.
     *
     * @param array $data The input data in array format.
     * @return string The converted data as an XML string.
     */
    public function convert(array $data): string
    {
        // Create the root XML element
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>');

        // Convert the array to XML
        $this->arrayToXml($xml, $data);

        // Format the XML Output with indentation
        return $xml->asXML();
    }

    /**
     * Recursively converts an array to XML elements and appends them to the given XML element.
     *
     * @param SimpleXMLElement $xml The parent XML element.
     * @param array $data The input data in array format.
     */
    private function arrayToXml(SimpleXMLElement $xml, array $data): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $xml->addChild($key);
                $this->arrayToXml($child, $value);
            } else {
                // If the value is a float, convert it to a string to avoid XML conversion issues
                $stringValue = is_float($value) ? strval($value) : $value;
                $xml->addChild($key, htmlspecialchars($stringValue));
            }
        }
    }
}
