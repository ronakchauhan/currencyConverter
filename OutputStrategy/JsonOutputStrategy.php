<?php

require_once "OutputStrategyInterface.php";

/**
 * JsonOutputStrategy class implements the OutputStrategyInterface for converting an array to JSON format.
 */
class JsonOutputStrategy implements OutputStrategyInterface
{
    /**
     * Converts an array to JSON format.
     *
     * @param array $data The input data in array format.
     * @return string The JSON formatted data as a string.
     */
    public function convert(array $data): string
    {
        return json_encode($data);
    }
}
