<?php

namespace BeInteractive\Jobrunner;

use BeInteractive\Jobrunner\Commands\JobrunnerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JobrunnerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('jobrunner')
            ->hasConfigFile(['jobrunner'])
            // ->hasViews()
            // ->hasMigration('create_jobrunner_table')
            ->hasCommand(JobrunnerCommand::class);
    }
}
