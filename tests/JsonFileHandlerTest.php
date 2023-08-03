<?php
require_once "FileReader/JsonFileHandler.php";

use PHPUnit\Framework\TestCase;

class JsonFileHandlerTest extends TestCase
{
    private string $validFilePath;
    private string $invalidFilePath;

    public function testReadDataValidJson()
    {
        $jsonFileHandler = new JsonFileHandler("assets/exchangeRates.json");
        $data = $jsonFileHandler->readData();

        $expectedData = ['baseCurrency' => 'EUR', 'exchangeRates' => ['EUR' => 1, 'USD' => 5, 'CHF' => 0.97, 'CNY' => 2.3,],];

        $this->assertEquals($expectedData, $data);
    }

    public function testReadDataEmptyFile()
    {
        $emptyFilePath = "assets/empty.json";
        // If the file does not exist or is not readable, we expect an exception to be thrown
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: $emptyFilePath");

        $jsonFileHandler = new JsonFileHandler($emptyFilePath);
        $jsonFileHandler->readData();
    }

    public function testReadDataNonExistentFile()
    {
        $nonExistentFilePath = "assets/non_existent.json";
        // If the file does not exist or is not readable, we expect an exception to be thrown
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: $nonExistentFilePath");

        $jsonFileHandler = new JsonFileHandler($nonExistentFilePath);
        $jsonFileHandler->readData();
    }

    public function testReadDataUnreadableFile()
    {
        $unreadableFilePath = "assets/unreadable.json";
        // If the file is unreadable, we expect an exception to be thrown
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: $unreadableFilePath");

        $jsonFileHandler = new JsonFileHandler($unreadableFilePath);
        $jsonFileHandler->readData();
    }

    public function testReadValidJsonFile()
    {
        $fileHandler = new JsonFileHandler($this->validFilePath);
        $data = $fileHandler->readData();

        $expectedData = ["baseCurrency" => "EUR", "exchangeRates" => ["EUR" => 1, "USD" => 5, "CHF" => 0.97, "CNY" => 2.3,],];

        $this->assertEquals($expectedData, $data);
    }

    public function testReadInvalidJsonFile()
    {
        try {
            $fileHandler = new JsonFileHandler($this->invalidFilePath);
            $data = $fileHandler->readData();
        } catch (Exception $e) {
            $expectedErrorMessage = 'File not found or not readable: ' . $this->invalidFilePath;
            $actualErrorMessage = $e->getMessage();
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        $this->fail('Expected exception was not thrown.');
    }

    protected function setUp(): void
    {
        $this->validFilePath = 'assets/exchangeRates.json';
        $this->invalidFilePath = 'assets/non_existent.json';
    }
}
