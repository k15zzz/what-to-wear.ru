<?php

namespace DB;

class DataBase
{
    private $dataBase;
    private $addingDataPrepare;
    private $acquisitionDataPrepare;

    function __construct(){
        $this->dataBase = new PDO("mysql:host=db;dbname=what-to-wear.ru;charset=utf8",
            'root', 'root',
            array(
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            ));
        $this->addingDataPrepare = $this->dataBase->prepare("INSERT INTO weather (dateUnixtime, temperature, 
            temperatureFeelsLike, weatherCondition, windSpee, airHumidity, probabilityPrecipitation)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $this->acquisitionDataPrepare = $this->dataBase->prepare("SELECT * FROM weather WHERE dateUnixtime = ?");
    }

    function AddingData( $dateUnixtime,  $temperature,  $temperatureFeelsLike,
                         $weatherCondition,  $windSpee,  $airHumidity,  $probabilityPrecipitation){
        $this->addingDataPrepare->bindParam(1, $dateUnixtime);
        $this->addingDataPrepare->bindParam(2, $temperature);
        $this->addingDataPrepare->bindParam(3, $temperatureFeelsLike);
        $this->addingDataPrepare->bindParam(4, $weatherCondition);
        $this->addingDataPrepare->bindParam(5, $windSpee);
        $this->addingDataPrepare->bindParam(6, $airHumidity);
        $this->addingDataPrepare->bindParam(7, $probabilityPrecipitation);
        $this->addingDataPrepare->execute();
    }

    function AcquisitionData($conditionDateUnixtime){
        return $this->acquisitionDataPrepare->execute($conditionDateUnixtime);
    }
}