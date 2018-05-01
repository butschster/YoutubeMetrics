<?php

namespace Tests\Unit\Youtube\Console;

use App\Console\Commands\Youtube\SyncVideoInformation;
use App\Jobs\Youtube\UpdateVideoInformation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SyncVideoInformationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_handle_command()
    {
        Bus::fake();

        $this->createVideo([
            'created_at' => now()->subHours($this->faker->numberBetween(1, 23))
        ], 5);

        $this->createVideo(['created_at' => now()->subDays(5)], 2);

        Artisan::call('youtube:video-information-sync');

        Bus::assertDispatched(UpdateVideoInformation::class, 5);
    }
}
