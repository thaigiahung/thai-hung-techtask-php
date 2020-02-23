# [Thái Gia Hưng] PHP Technical Task 

### Assumptions
1. AC3 require us to place the recipe which has less fresh ingredients at the bottom but did not clearly defined how to sort them. Therefore, I am sorting them in descending order by `best-before` column.

### Installation
1. Install dependencies using `composer`:
    ```
    composer install --dev
    ````
1. Run unit test and functional test:
    ```
    php bin/phpunit --coverage-text
    ```
1. Start application:
    ```
    symfony server:start
    ```
