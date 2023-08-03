# Use official PHP image
FROM php:8.1-cli

# Set working directory to /app
WORKDIR /app

# Copy the PHP files into the container
COPY . /app

# Set environment variable to non-interactive mode
ENV DEBIAN_FRONTEND noninteractive

# Update package lists and install apt-utils to resolve debconf errors
RUN apt-get update \
    && apt-get install -y --no-install-recommends apt-utils

# Install libxml2
# Install libxml2 and disable debconf warnings
RUN apt-get update && apt-get install -y libxml2-dev \
    && { \
        echo 'debconf debconf/frontend select Noninteractive'; \
        echo 'debconf debconf/priority select critical'; \
    } | debconf-set-selections

# Install BCMath extension
RUN docker-php-ext-install bcmath

# Download and install PHPUnit PHAR
RUN curl -LO https://phar.phpunit.de/phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/local/bin/phpunit

# Run the PHPUnit test or Run the application
#CMD ["php", "RunCurrencyExchange.php"]
CMD ["phpunit"]