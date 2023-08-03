# Currency Converter

The Currency Converter is a PHP Application that allows you to convert an amount from one currency to another using 
exchange rates provided in various file formats such as JSON, CSV, or XML.

## Features

- Support for converting an amount from one currency to another.
- Read exchange rates from JSON, CSV, and XML files.
- Support for custom file handlers by implementing the `FileHandlerInterface`.

## Requirements

- PHP 8.1 or higher

## Installation

1. Clone the repository to your local machine:

```bash
git clone https://github.com/your-username/currency-converter.git
cd currency-converter
```

2. Use docker build and Run Test cases using it:

```bash
docker build -t currencyconverter .
docker run -it --rm currencyconverter
```