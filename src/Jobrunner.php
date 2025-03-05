<?php

namespace BeInteractive\Jobrunner;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class Jobrunner {

    /**
     * Get all the commands that are scheduled to run
     *
     * @return \Illuminate\Support\Collection
     */
    public function getScheduledCommands(): \Illuminate\Support\Collection
    {
        return collect(
            app('Illuminate\Console\Scheduling\Schedule')->events()
        )->mapWithKeys(function ($command) {
            // remove the command signature from the command string
            $parts = explode(' ', $command->command);
            $clean = array_pop($parts);
            return [$clean =>[
                'command' => $command->command,
                'expression' => $command->expression,
            ]];
        });
    }

}
