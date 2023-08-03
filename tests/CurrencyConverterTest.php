<?php

use PHPUnit\Framework\TestCase;

require_once "Converter/CurrencyConverter.php";
require_once "OutputStrategy/JsonOutputStrategy.php";
require_once "OutputStrategy/CsvOutputStrategy.php";
require_once "OutputStrategy/XmlOutputStrategy.php";

class CurrencyConverterTest extends TestCase
{
    public function testConvertToUSDJson()
    {
        // Create the CurrencyConverter instance with the exchange rates file
        $converter = new CurrencyConverter('assets/exchangeRates.json', new JsonOutputStrategy());

        // Perform the conversion
        $result = $converter->convert(10, 'USD');

        // Expected output with a tolerance for floating-point precision
        $expectedOutput = '{"baseCurrency":"EUR","amount":"50.00","currency":"USD"}';

        // Compare the expected and actual results
        $this->assertEquals($expectedOutput, $result);
    }

    public function testConvertToUSDCsv()
    {
        // Create the CurrencyConverter instance with the exchange rates file and CSV output strategy
        $converter = new CurrencyConverter('assets/exchangeRates.json', new CsvOutputStrategy());

        // Perform the conversion
        $result = $converter->convert(10, 'USD');

        // Expected output for CSV format
        $expectedOutput = "baseCurrency,amount,currency" . PHP_EOL . "EUR,50.00,USD" . PHP_EOL;

        // Compare the expected and actual results
        $this->assertEquals($expectedOutput, $result);
    }

    public function testConvertToUSDXml()
    {
        // Create the CurrencyConverter instance with the exchange rates file
        $converter = new CurrencyConverter('assets/exchangeRates.json', new XmlOutputStrategy());

        // Perform the conversion
        $result = $converter->convert(10, 'USD');

        // Expected output with a tolerance for floating-point precision
        $expectedOutput = '<?xml version="1.0" encoding="UTF-8"?>
<data><baseCurrency>EUR</baseCurrency><amount>50.00</amount><currency>USD</currency></data>';

        // Compare the expected and actual results
        $this->assertXmlStringEqualsXmlString($expectedOutput, $result);
    }


    public function testConvertToCHF()
    {
        // Create the CurrencyConverter instance with the exchange rates file
        $converter = new CurrencyConverter('assets/exchangeRates.json', new JsonOutputStrategy());

        // Perform the conversion
        $result = $converter->convert(10, 'CHF');

        // Expected output with a tolerance for floating-point precision
        $expectedOutput = '{"baseCurrency":"EUR","amount":"9.70","currency":"CHF"}';

        // Compare the expected and actual results
        $this->assertEquals($expectedOutput, $result);
    }

    public function testConvertToCNY()
    {
        // Create the CurrencyConverter instance with the exchange rates file
        $converter = new CurrencyConverter('assets/exchangeRates.json', new JsonOutputStrategy());

        // Perform the conversion
        $result = $converter->convert(10, 'CNY');

        // Expected output with a tolerance for floating-point precision
        $expectedOutput = '{"baseCurrency":"EUR","amount":"23.00","currency":"CNY"}';

        // Compare the expected and actual results
        $this->assertEquals($expectedOutput, $result);
    }


    public function testConvertToEUR()
    {
        // Create the CurrencyConverter instance with the exchange rates file
        $converter = new CurrencyConverter('assets/exchangeRates.json', new JsonOutputStrategy());

        // Perform the conversion
        $result = $converter->convert(10, 'EUR');

        // Expected output with a tolerance for floating-point precision
        $expectedOutput = '{"baseCurrency":"EUR","amount":"10.00","currency":"EUR"}';

        // Compare the expected and actual results
        $this->assertEquals($expectedOutput, $result);
    }

    public function testConvertNegativeAmount()
    {
        // Create the CurrencyConverter instance with the exchange rates file
        $converter = new CurrencyConverter('assets/exchangeRates.json', new JsonOutputStrategy());

        // Perform the conversion with a negative amount
        $result = $converter->convert(-50, 'USD');

        // Expected output with the error message
        $expectedOutput = '{"error":"Invalid amount: Amount must be a positive number"}';

        // Actual output from the conversion
        $actualOutput = $result;

        // Compare the expected and actual output
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testConvertInvalidTargetCurrency()
    {
        // Test with invalid target currency
        $filePath = "assets/exchangeRates.json";
        $currencyConverter = new CurrencyConverter($filePath, new JsonOutputStrategy());

        $amount = 10;
        $targetCurrency = "INVALID";
        $result = $currencyConverter->convert($amount, $targetCurrency);

        $expectedResult = json_encode(['error' => 'Invalid target currency']);

        $this->assertEquals($expectedResult, $result);
    }

    public function testConvertNonExistentFile()
    {
        // Create the CurrencyConverter instance with a non-existent file
        try {
            $converter = new CurrencyConverter('assets/non_existent.json', new JsonOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with a non-existent file
            $expectedErrorMessage = 'File not found or not readable: assets/non_existent.json';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertUnreadableFile()
    {
        // Create the CurrencyConverter instance with an unreadable file
        try {
            $converter = new CurrencyConverter('assets/unreadable.json', new JsonOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an unreadable file
            $expectedErrorMessage = 'File not found or not readable: assets/unreadable.json';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertInvalidJsonFile()
    {
        // Create the CurrencyConverter instance with an invalid JSON file
        try {
            $converter = new CurrencyConverter('assets/invalid.json', new JsonOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an invalid JSON file
            $expectedErrorMessage = 'File not found or not readable: assets/invalid.json';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertEmptyJsonFile()
    {
        // Create the CurrencyConverter instance with an empty JSON file
        try {
            $converter = new CurrencyConverter('assets/empty.json', new JsonOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an empty JSON file
            $expectedErrorMessage = 'File not found or not readable: assets/empty.json';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertInvalidCsvFile()
    {
        // Create the CurrencyConverter instance with an invalid CSV file
        try {
            $converter = new CurrencyConverter('assets/invalid.csv', new CsvOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an invalid CSV file
            $expectedErrorMessage = 'File not found or not readable: assets/invalid.csv';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertEmptyCsvFile()
    {
        // Create the CurrencyConverter instance with an empty CSV file
        try {
            $converter = new CurrencyConverter('assets/empty.csv', new CsvOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an empty CSV file
            $expectedErrorMessage = 'File not found or not readable: assets/empty.csv';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertInvalidXmlFile()
    {
        // Create the CurrencyConverter instance with an invalid XML file
        try {
            $converter = new CurrencyConverter('assets/invalid.xml', new XmlOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an invalid XML file
            $expectedErrorMessage = 'File not found or not readable: assets/invalid.xml';

            // Actual error message from the exception
            $actualErrorMessage = $e->getMessage();

            // Compare the expected and actual error messages
            $this->assertEquals($expectedErrorMessage, $actualErrorMessage);
            return;
        }

        // If the exception was not thrown, the test should fail
        $this->fail('Expected exception was not thrown.');
    }


    public function testConvertEmptyXmlFile()
    {
        // Create the CurrencyConverter instance with an empty XML file
        try {
            $converter = new CurrencyConverter('assets/empty.xml', new XmlOutputStrategy());

            // Perform the conversion (not relevant for this test)
            $result = $converter->convert(10, 'USD');
        } catch (Exception $e) {
            // Expected error message when trying to initialize CurrencyConverter with an empty XML file
            $expectedErrorMessage = 'File not found or not readable: assets/empty.xml';

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
