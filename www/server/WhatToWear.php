<?php

namespace WhatToWear;

class Weather
{
    private  $temperature;
    private  $windSpeed;
    private  $rain;
    private  $weatherStatus;

    /*
    Существует 7 статусов погоды:
    0-Очень холодно(Пуховик, шарф, варжеки)
    1-Холодно(Пуховик без запки)
    2-Осеняя погода(Пальто и кофта)
    3-Весеняя погода(Пальто и футболка)
    4-Позднее лето(Кофта)
    5-Лето(Футболка и рубшка)
    6-Очень жарко (фуболка и шорты)
    */

    public function __construct( $temperature,  $windSpeed,  $rain)
    {
        $this->temperature = $temperature;
        $this->windSpeed = $windSpeed;
        $this->rain = $rain;
        $this->ConfigurationWeatherStatus();
    }


    public function ConfigurationWeatherStatus()
    {
        if ($this->temperature > 15 && $this->windSpeed < 3) {
            $this->weatherStatus = 5;
        } elseif ($this->temperature < 15 && $this->windSpeed > 3 && $this->windSpeed < 6) {
            $this->weatherStatus = 4;
        } elseif ($this->temperature < 0 && $this->windSpeed < 6) {
            $this->weatherStatus = 3;
        } elseif ($this->temperature < 10 && $this->windSpeed < 6) {
            $this->weatherStatus = 2;
        } elseif ($this->temperature < 20) {
            $this->weatherStatus = 1;
        } else {
            $this->weatherStatus = 0;
        }
    }

    public function GetInfoAboutWeatherStatus()
    {
        return $this->weatherStatus;
    }

    public function GetInfoAboutRain()
    {
        return $this->rein;
    }

    public function GetInfoAboutTemperature()
    {
        return $this->temperature;
    }

    public function GetInfoAboutWindSpeed()
    {
        return $this->windSpeed;
    }
}

