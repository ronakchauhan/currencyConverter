<?php

require_once "CurrencyConverterInterface.php";
require_once "FileReader/FileReader.php";
require_once "OutputStrategy/OutputStrategyInterface.php";

/**
 * Class CurrencyConverter
 * Implements the CurrencyConverterInterface to provide currency conversion functionality.
 */
class CurrencyConverter implements CurrencyConverterInterface
{
    private array $exchangeRates;
    private string $baseCurrency;
    private OutputStrategyInterface $outputStrategy;

    /**
     * CurrencyConverter constructor.
     *
     * @param string $filePath The file path to read exchange rates from.
     * @throws Exception If there is an error while reading the file or converting the data.
     */
    public function __construct(string $filePath, OutputStrategyInterface $outputStrategy)
    {
        // Check if the file exists and is readable before proceeding
        if (!is_readable($filePath)) {
            throw new InvalidArgumentException("File not found or not readable: $filePath");
        }

        try {
            $this->outputStrategy = $outputStrategy;
            $fileReader = new FileReader($filePath);
            $this->baseCurrency = $fileReader->getBaseCurrency();
            $this->exchangeRates = $fileReader->getExchangeRates();
        } catch (Exception $e) {
            throw new Exception("Failed to initialize CurrencyConverter: " . $e->getMessage());
        }
    }

    /**
     * Convert given amount into targeted currency based on the exchange rates.
     *
     * @param float $amount The amount to be converted.
     * @param string $targetCurrency The target currency to convert to.
     * @return string Returns the converted amount in JSON format.
     */
    public function convert(float $amount, string $targetCurrency): string
    {
        if ($amount <= 0) {
            return json_encode(['error' => 'Invalid amount: Amount must be a positive number']);
        }

        if (!isset($this->exchangeRates[$targetCurrency])) {
            return json_encode(['error' => 'Invalid target currency']);
        }

        $rate = $this->exchangeRates[$targetCurrency];
        $convertedAmount = bcmul($amount, $rate, 2);

        $result = ['baseCurrency' => $this->baseCurrency, 'amount' => $convertedAmount, 'currency' => $targetCurrency];

        return $this->outputStrategy->convert($result);
    }
}
