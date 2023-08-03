<?php
require_once "FileReader/XmlFileHandler.php";

use PHPUnit\Framework\TestCase;


class XmlFileHandlerTest extends TestCase
{
    public function testReadDataValidXml()
    {
        // Create the XmlFileHandler instance with a valid XML file
        $filePath = 'assets/exchangeRates.xml';
        $fileHandler = new XmlFileHandler($filePath);

        // Read data from the XML file
        $data = $fileHandler->readData();

        // Expected data from the XML file
        $expectedData = ['baseCurrency' => 'EUR', 'exchangeRates' => ['EUR' => 1, 'USD' => 5, 'CHF' => 0.97, 'CNY' => 2.3,],];

        // Compare the expected data with the actual data
        $this->assertEquals($expectedData, $data);
    }

    public function testReadDataEmptyFile()
    {
        // Create the XmlFileHandler instance with an empty file
        $filePath = 'assets/empty.xml';
        try {
            $fileHandler = new XmlFileHandler($filePath);

            // Try to read data from the empty file (not relevant for this test)
            $data = $fileHandler->readData();
        } catch (Exception $e) {
            // Expected error message when trying to read from an empty XML file
            $expectedErrorMessage = 'File not found or not readable: ' . $filePath;

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testReadDataNonExistentFile()
    {
        // Create the XmlFileHandler instance with a non-existent file
        $filePath = 'assets/non_existent.xml';
        try {
            $fileHandler = new XmlFileHandler($filePath);

            // Try to read data from the non-existent file (not relevant for this test)
            $data = $fileHandler->readData();
        } catch (Exception $e) {
            // Expected error message when trying to read from a non-existent XML file
            $expectedErrorMessage = 'File not found or not readable: ' . $filePath;

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }

    public function testReadDataUnreadableFile()
    {
        // Create the XmlFileHandler instance with an unreadable file
        $filePath = 'assets/unreadable.xml';
        try {
            $fileHandler = new XmlFileHandler($filePath);

            // Try to read data from the unreadable file (not relevant for this test)
            $data = $fileHandler->readData();
        } catch (Exception $e) {
            // Expected error message when trying to read from an unreadable XML file
            $expectedErrorMessage = 'File not found or not readable: ' . $filePath;

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }

}
