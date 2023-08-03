<?php
require_once "FileHandlerInterface.php";

/**
 * Class JsonFileHandler
 * Implements the FileHandlerInterface for handling Json files.
 */
class JsonFileHandler implements FileHandlerInterface
{
    private string $filePath;

    /**
     * JsonFileHandler constructor.
     *
     * @param string $filePath The path to the JSON file.
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
     * Read data from the JSON file and return it as an array.
     *
     * @return array An array containing the JSON data or an empty array if the JSON file is empty.
     * @throws Exception If there is an error while reading the JSON file.
     */
    public function readData(): array
    {
        // Read JSON data from the file
        $jsonData = file_get_contents($this->filePath);
        if ($jsonData === false) {
            throw new Exception("Failed to read JSON file: " . $this->filePath);
        }

        // Decode JSON data with JSON_THROW_ON_ERROR option
        try {
            $decodedData = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new Exception("Error decoding JSON file: " . $e->getMessage());
        }

        // Return the decoded data or an empty array if the JSON file is empty
        return $decodedData ?? [];
    }
}
