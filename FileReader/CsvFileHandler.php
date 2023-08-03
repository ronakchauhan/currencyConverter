<?php

require_once "FileHandlerInterface.php";

/**
 * Class CsvFileHandler
 * Implements the FileHandlerInterface for handling CSV files.
 */
class CsvFileHandler implements FileHandlerInterface
{
    private string $filePath;

    /**
     * CsvFileHandler constructor.
     * @param string $filePath The path to the CSV file.
     * @throws InvalidArgumentException If the file is not found or not readable.
     */
    public function __construct(string $filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new InvalidArgumentException("File not found or not readable: $filePath");
        }

        $this->filePath = $filePath;
    }

    /**
     * @inheritDoc
     *
     * @return array|false Returns an array containing the CSV data or false on failure.
     * @throws Exception If there is an error while reading the CSV file.
     */
    public function readData(): array|false
    {
        // Read CSV data from the file and return it as an array
        $rows = [];
        if (($handle = fopen($this->filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
            return $rows;
        } else {
            throw new Exception('Failed to open CSV file: ' . $this->filePath);
        }
    }
}
