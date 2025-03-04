<?php

namespace BeInteractive\Jobrunner;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use BeInteractive\Jobrunner\Commands\JobrunnerCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_jobrunner_table')
            ->hasCommand(JobrunnerCommand::class);
    }
}
