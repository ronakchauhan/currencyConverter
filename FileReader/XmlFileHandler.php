<?php
require_once "FileHandlerInterface.php";

/**
 * Class XmlFileHandler
 * Implements the FileHandlerInterface for handling Xml files.
 */
class XmlFileHandler implements FileHandlerInterface
{
    private string $filePath;

    /**
     * XmlFileHandler constructor.
     *
     * @param string $filePath The path to the XML file.
     * @throws InvalidArgumentException If the file is not found or not readable.
     */
    public function __construct(string $filePath)
    {
        // Check if the file exists and is readable before proceeding
        if (!is_readable($filePath)) {
            throw new InvalidArgumentException("File not found or not readable: $filePath");
        }

        $this->filePath = $filePath;
    }

    /**
     * Read data from the XML file and return it as an array.
     *
     * @return array An array containing the XML data or an empty array on failure.
     * @throws Exception If there is an error while reading the XML file or converting to an array.
     */
    public function readData(): array
    {
        $xmlData = file_get_contents($this->filePath);
        if ($xmlData === false) {
            throw new Exception("Failed to read XML file: " . $this->filePath);
        }

        $xml = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xml === false) {
            throw new Exception("Error parsing XML: " . libxml_get_last_error()->message);
        }

        $jsonData = json_encode($xml);
        if ($jsonData === false) {
            throw new Exception("Error converting XML to JSON: " . json_last_error_msg());
        }

        return json_decode($jsonData, true) ?? [];
    }
}
