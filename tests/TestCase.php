<?php

namespace IndieHD\Velkart\Tests;

use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Factory as FactoriesFactory;
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
     * Set up the test.
     */
    public function setUp(): void
    {
        parent::setUp();

        FactoriesFactory::guessFactoryNamesUsing(function ($name) {
            return (string) '\\IndieHD\\Velkart\\Database\\Factories\\'.
                (class_basename($name)).
                'Factory';
        });

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
            'driver'                  => 'sqlite',
            'database'                => ':memory:',
            'foreign_key_constraints' => true,
        ]);
    }
}
