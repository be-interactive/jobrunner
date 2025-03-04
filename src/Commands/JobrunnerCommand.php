<?php

namespace BeInteractive\Jobrunner\Commands;

use Illuminate\Console\Command;

class JobrunnerCommand extends Command
{
    public $signature = 'jobrunner';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
