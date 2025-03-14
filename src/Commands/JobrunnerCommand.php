<?php

namespace BeInteractive\Jobrunner\Commands;

use BeInteractive\Jobrunner\Facades\Jobrunner;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;

class JobrunnerCommand extends Command
{
    public $signature = 'jobrunner';

    public $description = 'Run any command in your Laravel application';

    public function handle(): int
    {

        // Check if All commands is available as an option
        $type = 'Scheduled commands';
        if (! is_null(\Jobrunner::getFolders())) {
            $type = select(
                label: 'What type of Command would you like to choose from?',
                options: ['All commands', 'Scheduled commands']
            );
        }

        if ($type === 'All commands') {
            // List all the commands that are available
            $commands = Jobrunner::getCommands();
        } else {
            // List all the commands that are scheduled to run
            $commands = Jobrunner::getScheduledCommands();
        }

        // Ask the user to choose a command
        $commandKey = select(
            label: 'What command would you like to run?',
            options: $commands->keys()->toArray()
        );
        // $command = $commands->get($commandKey);

        // Run the chosen command
        $this->comment('Running command ['.$commandKey.']');
        $this->line('---------------------------------');

        // todo: run jobs and closures

        $this->call($commandKey);
        $this->line('---------------------------------');

        return self::SUCCESS;
    }
}
