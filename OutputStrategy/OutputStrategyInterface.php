<?php

/**
 * OutputStrategyInterface defines the contract for output strategies that convert data to a specific format.
 */
interface OutputStrategyInterface
{
    /**
     * Converts an array of data to a specific format.
     *
     * @param array $data The input data in array format.
     * @return string The converted data as a string.
     */
    public function convert(array $data): string;
}
