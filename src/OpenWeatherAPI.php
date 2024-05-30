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

    public function handleIO(Interactor $io): array {
        $data = [
            'Temperature' => "{$this->getTemp()}oC",
            'Feels like' => "{$this->getFeelsLike()}oC",
            'Pressure' => "{$this->getPressure()}mPa",
            'Humidity' => "{$this->getHumidity()}%",
            'Wind' => "{$this->getWindSpeed()}m/s",
        ];

        foreach ($data as $key => $value) {
            $io->write($key . ': ' . $value . "\n");
        }

        return $data;
    }

}
