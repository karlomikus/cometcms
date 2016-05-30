<?php

use Comet\Core\Services\OpponentService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OpponentServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = $this->app[OpponentService::class];
    }

    /** @test */
    public function it_gets_all_opponents()
    {
        $opponents = $this->service->getOpponents();

        $this->assertCount(10, $opponents);
    }

    /** @test */
    public function it_gets_a_single_opponent()
    {
        $opponent = $this->service->getOpponent(1);

        $this->assertInstanceOf('Comet\Core\Models\Opponent', $opponent);
    }
}