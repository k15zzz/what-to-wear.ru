<?php
namespace API;

class WeatherYandexApi{
    private $opts = [
        'http' => array(
            'method'=>"GET",
            'header' => "X-Yandex-API-Key:311b9820-e604-44e6-8ac9-cf0947853dbc"."\r\n"
        )
    ];

    private $dateUnixtime;
    private $temperature;
    private $temperatureFeelsLike;
    private $weatherCondition;
    private $windSpee;
    private $airHumidity;
    private $probabilityPrecipitation;

    private $object;

    public function __construct($coordinates){
        $context = stream_context_create($this->opts);
        $jsonObject=file_get_contents("https://api.weather.yandex.ru/v2/informers?lat=".$coordinates[0]."&lon=".$coordinates[1],false,$context);
        $this->object=json_decode($jsonObject);
        $forecast=$this->object->forecast;
        $this->dateUnixtime = $forecast->date_ts;
        $this->temperature = $forecast->parts[1]->temp_avg;
        $this->temperatureFeelsLike = $forecast->parts[1]->feels_like;
        $this->weatherCondition = $forecast->parts[1]->condition;
        $this->windSpee = $forecast->parts[1]->wind_speed;
        $this->airHumidity = $forecast->parts[1]->humidity;
        $this->probabilityPrecipitation = $forecast->parts[1]->prec_prob;
    }

    public function GetWeatherUnits(){
        return [
            'dateUnixtime'=>$this->dateUnixtime,
            'temperature'=>$this->temperature,
            'temperatureFeelsLike'=>$this->temperatureFeelsLike,
            'weatherCondition'=>$this->weatherCondition,
            'windSpee'=>$this->windSpee,
            'airHumidity'=>$this->airHumidity,
            'probabilityPrecipitation' =>$this->probabilityPrecipitation
        ];
    }
}

class GeocodeYandexApi{
    private $address;
    private $coordinates;

    public function __construct($address){
        $this->address=$this->PreparingAddress($address);
        $this->ConnectionApi();
    }

    private function PreparingAddress( $address){
        return str_replace(",", "+",  str_replace(" ", "",  $address));
    }

    private function ConnectionApi(){
        $ch = curl_init('https://geocode-maps.yandex.ru/1.x/?format=json&'.
            'apikey=2f7580e5-5cb6-4e6b-975d-becc278d7e8d&lang=ru_RU&results=1&geocode='.urlencode($this->address));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        $coordinat = $res['response']['GeoObjectCollection']
        ['featureMember'][0]['GeoObject']['Point']['pos'];
        $this->coordinates = explode(' ', $coordinat);
    }

    public function GetCoordinates(){
        return $this->coordinates;
    }
}
