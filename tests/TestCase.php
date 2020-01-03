<?php

namespace IndieHD\Velkart\Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use IndieHD\Velkart\VelkartServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected $session;
    protected $events;
    protected $faker;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../database/factories');

        $this->faker = Factory::create();
        $this->session = $this->app->make('session');
        $this->events = $this->app->make('events');
    }

    protected function getPackageProviders($app)
    {
        return [
            VelkartServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
