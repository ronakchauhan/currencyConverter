<?php

/**
 * Interface CurrencyConverterInterface
 * Defines the contract for currency conversion.
 */
interface CurrencyConverterInterface
{
    /**
     * Convert the given amount into the targeted currency based on the exchange rates.
     *
     * @param float $amount The amount to be converted.
     * @param string $targetCurrency The target currency code to convert to.
     * @return string Returns the converted amount in a formatted string.
     */
    public function convert(float $amount, string $targetCurrency): string;
}
