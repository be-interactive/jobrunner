<?php

namespace BeInteractive\Jobrunner\Tests\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test:command';

    protected $description = 'A test command for scheduled jobs';

    public static bool $ran = false;

    public function handle(): void
    {
        self::$ran = true;
        $this->info('Test command executed!');
    }
}
