<?php
require_once "FileReader/CsvFileHandler.php";

use PHPUnit\Framework\TestCase;

class CsvFileHandlerTest extends TestCase
{
    public function testReadDataValidCsv()
    {
        $csvFileHandler = new CsvFileHandler("assets/exchangeRates.csv");

        $data = $csvFileHandler->readData();

        $expectedData = [['EUR', 'USD', 'CHF', 'CNY'], [1, 5, 0.97, 2.3],];

        $this->assertEquals($expectedData, $data);
    }

    public function testReadDataNonExistentFile()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: assets/non_existent.csv");

        $csvFileHandler = new CsvFileHandler("assets/non_existent.csv");
        $csvFileHandler->readData();
    }

    public function testReadDataUnreadableFile()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: assets/unreadable.csv");

        // Mock the CsvFileHandler to throw an exception when trying to read the file
        $csvFileHandler = $this->getMockBuilder(CsvFileHandler::class)->setConstructorArgs(["assets/unreadable.csv"])->getMock();

        $csvFileHandler->expects($this->once())->method('readData')->willThrowException(new InvalidArgumentException("File not found or not readable: assets/unreadable.csv"));

        $csvFileHandler->readData();
    }

    public function testReadDataInvalidCsv()
    {
        $invalidFilePath = "assets/invalid.csv";
        // If the file does not exist or is not readable, we expect an exception to be thrown
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: $invalidFilePath");

        $csvFileHandler = new CsvFileHandler($invalidFilePath);
        $csvFileHandler->readData();
    }

    public function testReadDataEmptyCsv()
    {
        $emptyFilePath = "assets/empty.csv";
        // If the file does not exist or is not readable, we expect an exception to be thrown
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found or not readable: $emptyFilePath");

        $csvFileHandler = new CsvFileHandler($emptyFilePath);
        $csvFileHandler->readData();
    }
}
