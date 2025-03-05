<?php

namespace BeInteractive\Jobrunner\Commands;

use BeInteractive\Jobrunner\Facades\Jobrunner;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;

class JobrunnerCommand extends Command
{
    public $signature = 'jobrunner';

    public $description = 'My command';

    public function handle(): int
    {

        // List all the commands that are scheduled to run
        $commands = Jobrunner::getScheduledCommands();

        // Ask the user to choose a command
        $commandKey = select(
            label: 'What command would you like to run?',
            options: $commands->keys()->toArray()
        );
        // $command = $commands->get($commandKey);

        // Run the chosen command
        $this->comment('Running command ['.$commandKey.']');
        $this->line('---------------------------------');
        $this->call($commandKey);
        $this->line('---------------------------------');

        return self::SUCCESS;
    }
}
