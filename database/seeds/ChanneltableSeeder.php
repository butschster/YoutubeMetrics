<?php

use App\Entities\Channel;
use Illuminate\Database\Seeder;

class ChanneltableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::truncate();

        $channels = [
            [
                'id' => 'UCDbsY8C1eQJ5t6KBv9ds-ag',
                'title' => 'kamikadzedead'
            ],
            [
                'id' => 'UCgxTPTFbIbCWfTR9I2-5SeQ',
                'title' => 'Навальный LIVE'
            ],
            [
                'id' => 'UCnAmkiIpUXkVOY1A1r-zE6w',
                'title' => 'Sasha Sotnik'
            ],
            [
                'id' => 'UCsAw3WynQJMm7tMy093y37A',
                'title' => 'Алексей Навальный'
            ],
//            [
//                'id' => 'UCVPYbobPRzz0SjinWekjUBw',
//                'title' => 'Анатолий Шарий'
//            ],
            [
                'id' => 'UCm-NTe-zNrgPpee58vLK6Bw',
                'title' => 'PutinTeam'
            ],
            [
                'id' => 'UC8A3q_snMexFcVviNMRLKdg',
                'title' => 'Евгений Ройзман'
            ],
            [
                'id' => 'UCXoAjrdHFa2hEL3Ug8REC1w',
                'title' => 'DW (Russian)'
            ],
            [
                'id' => 'UC5Z2ZmwAJhPLRIBUVkQljMg',
                'title' => 'Politics Russia - Ukraine'
            ]
        ];

        foreach ($channels as $attributes) {
            Channel::forceCreate($attributes);
        }
    }
}
