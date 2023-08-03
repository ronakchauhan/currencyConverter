<?php

require_once "FileHandlerInterface.php";
require_once "JsonFileHandler.php";
require_once "CsvFileHandler.php";
require_once "XmlFileHandler.php";

/**
 * Class FileReader
 * Handles reading data from different file types (JSON, CSV, XML) using the corresponding handlers.
 */
class FileReader implements FileHandlerInterface
{
    private FileHandlerInterface $handler;

    /**
     * FileReader constructor.
     *
     * @param string $filePath The path to the file to be read.
     * @throws Exception If there is an error while initializing the appropriate handler for the file type.
     */
    public function __construct(string $filePath)
    {
        $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
        $this->handler = match ($fileType) {
            'json' => new JsonFileHandler($filePath),
            'csv' => new CsvFileHandler($filePath),
            'xml' => new XmlFileHandler($filePath),
            default => throw new Exception("Unsupported file type: $fileType"),
        };
    }

    /**
     * Get the base currency from the file data.
     *
     * @return string|null The base currency or null if not found in the file data.
     * @throws Exception
     */
    public function getBaseCurrency(): ?string
    {
        $data = $this->readData();
        return $data['baseCurrency'] ?? null;
    }

    /**
     * Read data from the file using the appropriate handler.
     *
     * @return array An array containing the data read from the file.
     * @throws Exception If there is an error while reading the file.
     */
    public function readData(): array
    {
        try {
            return $this->handler->readData();
        } catch (Exception $e) {
            throw new Exception("Error while reading data: " . $e->getMessage());
        }
    }

    /**
     * Get the exchange rates from the file data.
     *
     * @return array|null The exchange rates or null if not found in the file data.
     * @throws Exception
     */
    public function getExchangeRates(): ?array
    {
        $data = $this->readData();
        return $data['exchangeRates'] ?? null;
    }
}
