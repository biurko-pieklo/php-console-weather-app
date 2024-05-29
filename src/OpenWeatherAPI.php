<?php

namespace weather;

use Ahc\Cli\IO\Interactor;

class OpenWeatherAPI {
    private array $data;

    public function __construct($lat, $lng) {
        $api_key = OPENWEATHERMAP_API_KEY;
        $this->data = json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lng}&appid={$api_key}&units=metric"), true);
    }

    public function getTemp() {
        return $this->data['main']['temp'];
    }

    public function getFeelsLike() {
        return $this->data['main']['feels_like'];
    }

    public function getPressure() {
        return $this->data['main']['pressure'];
    }

    public function getHumidity() {
        return $this->data['main']['humidity'];
    }

    public function getWindSpeed() {
        return $this->data['wind']['speed'];
    }

    public function handleIO(Interactor $io) {
        $io->write("Temperatura: {$this->getTemp()}oC", true);
        $io->write("Temperatura odczuwalna: {$this->getFeelsLike()}oC", true);
        $io->write("Ciśnienie: {$this->getPressure()}mPa", true);
        $io->write("Wilgotność: {$this->getHumidity()}%", true);
        $io->write("Prędkość wiatru: {$this->getWindSpeed()}m/s", true);

        return [
            'Temperatura' => $this->getTemp(),
            'Odczuwalna' => $this->getFeelsLike(),
            'Ciśnienie' => $this->getPressure(),
            'Wilgotność' => $this->getHumidity(),
            'Wiatr' => $this->getWindSpeed(),
        ];
    }

}
