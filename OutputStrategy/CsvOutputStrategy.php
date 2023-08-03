<?php

require_once "OutputStrategyInterface.php";

/**
 * CsvOutputStrategy class implements the OutputStrategyInterface for converting an array to CSV format.
 */
class CsvOutputStrategy implements OutputStrategyInterface
{
    /**
     * Converts an array to CSV format.
     *
     * @param array $data The input data in array format.
     * @return string The CSV formatted data as a string.
     */
    public function convert(array $data): string
    {
        // Convert the array to CSV format
        $csvString = implode(',', array_keys($data)) . PHP_EOL; // Header row
        $csvString .= implode(',', $data) . PHP_EOL; // Data row

        return $csvString;
    }
}
