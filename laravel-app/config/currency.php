<?php

return [
    'apikey' => getenv('CURRENCY_API_KEY') ?: die('The API KEY variable must be set in .env check env.example for reference.'),
    'base' => 'https://api.apilayer.com/currency_data/',
];
