<?php

require_once 'API.php';
require_once 'DataBase.php';

use API\GeocodeYandexApi;
use API\WeatherYandexApi;

$address = "Россия, Тюменская область, Тюмень";

$geocodeApi = new GeocodeYandexApi($address);

$coordinates = $geocodeApi->GetCoordinates();

$weatherApi = new WeatherYandexApi($coordinates);

$weatherUnits = $weatherApi->GetWeatherUnits();

echo json_encode($weatherUnits);





