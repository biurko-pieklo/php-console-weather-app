<?php

namespace weather;

use Ahc\Cli\Input\Command;
use Ahc\Cli\IO\Interactor;

class WeatherCommand extends Command
{
    public function __construct()
    {
        parent::__construct('weather', 'Get the weather');
    }

    public function interact(Interactor $io) : void
    {
        $io->write('Dostępne miasta:', true);

        $json = json_decode(file_get_contents(__DIR__.'/../res/cities.json'), true);

        foreach ($json as $name => $coords) {
            $io->write($name, true);
        }

        $io->write('wpisz "exit", aby skończyć', true);

        $selected = [];

        while (true) {
            $city = $io->prompt('Wybierz miasto');

            if ($city == 'exit') {
                break;
            } else if (array_key_exists($city, $selected)) {
                $io->write('To miasto jest już wybrane', true);
            } else if (array_key_exists($city, $json)) {
                $api = new OpenWeatherAPI($json[$city]['lat'], $json[$city]['lng']);
                $data = $api->handleIO($io);
                $selected[$city] = $data;
            } else {
                $io->write('Nie możesz wybrać takiego miasta.', true);
            }
        }

        $this->set('cities', $selected);

        while (true) {
            $format = $io->prompt('Do jakiego formatu zapisać dane? (PDF, JSON, XML)');

            if (!in_array(strtoupper($format), AVAILABLE_FORMATS)) {
                $io->write('Wybierz poprawny format.', true);
            } else {
                break;
            }
        }

        $this->set('format', strtoupper($format));
    }

    public function execute(array $cities, string $format)
    {
        $io = $this->app()->io();

        match ($format) {
            'PDF' => Writer::toPDF($cities),
            'JSON' => Writer::toJSON($cities),
            'XML' => Writer::toXML($cities),
        };
    }
}
