<?php

namespace BeInteractive\Jobrunner\Tests;

use BeInteractive\Jobrunner\JobrunnerServiceProvider;
use BeInteractive\Jobrunner\Tests\Console\Commands\TestCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BeInteractive\\Jobrunner\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            JobrunnerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Access the scheduler and schedule the test command
        $schedule = $app->make(Schedule::class);
        $schedule->command(TestCommand::class)->everyFiveMinutes();
    }
}
