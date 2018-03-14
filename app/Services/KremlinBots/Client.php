<?php

namespace App\Services\KremlinBots;

use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Collection;

class Client
{
    const URL = 'https://raw.githubusercontent.com/YTObserver/YT-ACC-DB/master/mainDB';

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        $response = $this->client->get(static::URL);

        return $this->parseList(
            $response->getBody()->getContents()
        );
    }

    /**
     * @param string $response
     * @return Collection
     */
    protected function parseList(string $response): Collection
    {
        return collect(explode(PHP_EOL, $response))
            ->map(function ($row) {
                $data = explode('=', $row, 2);

                return [
                    'id' => $data[0] ?? null,
                    'date' => isset($data[1]) ? $this->parseDate($data[1]) : null
                ];
            })
            ->filter(function ($data) {
                return !empty($data['id']);
            });
    }

    /**
     * @return array
     */
    protected function monthsMap(): array
    {
        return [
            'января' => '01',
            'февраля' => '02',
            'марта' => '03',
            'апреля' => '04',
            'мая' => '05',
            'июня' => '06',
            'июля' => '07',
            'августа' => '08',
            'сентября' => '09',
            'октября' => '10',
            'ноября' => '11',
            'декабря' => '12'
        ];
    }


    /**
     * @param string $string
     * @return Carbon|null
     */
    protected function parseDate(string $string): ?Carbon
    {
        $date = strtr(strtolower($string), $this->monthsMap());

        preg_match('/(?<day>\d{1,2})\s+(?<month>\d{2})\s+(?<year>\d{1,4})/u', $date, $matches);

        if (!isset($matches['day']) || !isset($matches['month']) || !isset($matches['year'])) {
            return null;
        }

        try {
            return Carbon::createFromDate($matches['year'], $matches['month'], $matches['day']);
        } catch (\Exception $e) {
        }
    }
}