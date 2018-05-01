<?php

namespace Tests\Unit\Channel;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportsTest extends TestCase
{
    use RefreshDatabase;

    function test_a_user_can_sent_report_to_channel()
    {
        $user = $this->createUser();
        $user1 = $this->createUser();
        $channel = $this->createChannel(['bot' => false, 'total_reports' => 0]);

        $this->assertEquals(0, $channel->total_reports);
        $this->assertEquals(0, $channel->reports()->count());

        $channel->sendReport($user);
        $channel->sendReport($user1);

        $this->assertEquals(2, $channel->total_reports);
        $this->assertEquals(2, $channel->reports()->count());
    }

    function test_check_if_user_reported_a_channel()
    {
        $user = $this->createUser();
        $user1 = $this->createUser();
        $channel = $this->createChannel(['bot' => false, 'total_reports' => 0]);

        $channel->sendReport($user);

        $this->assertTrue($channel->hasReportFrom($user));
        $this->assertFalse($channel->hasReportFrom($user1));
    }
}
