<?php
require_once "Converter/CurrencyConverter.php";
require_once "OutputStrategy/XmlOutputStrategy.php";

// Create an instance of the CurrencyConverter with the JSON output strategy
$currencyConverter = new CurrencyConverter("assets/exchangeRates.json", new XmlOutputStrategy());

// Convert the amount to the target currency and get the result in JSON format
$jsonResult = $currencyConverter->convert(100, 'USD');

echo $jsonResult;