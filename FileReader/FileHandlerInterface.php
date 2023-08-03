<?php

/**
 * Interface FileHandlerInterface
 * Represents a file handler for reading data from a file.
 */
interface FileHandlerInterface
{
    /**
     * Read data from a file and return it as an array.
     *
     * @return array|false An array containing the data read from the file or false on failure.
     */
    public function readData(): array|false;
}
