<?php

namespace BeInteractive\Jobrunner;

class Jobrunner
{
    /**
     * Get all the commands that are scheduled to run
     */
    public function getScheduledCommands(): \Illuminate\Support\Collection
    {
        return collect(
            app('Illuminate\Console\Scheduling\Schedule')->events()
        )->mapWithKeys(function ($event) {
            // remove the command signature from the command string
            $parts = explode(' ', $event->command);
            $clean = array_pop($parts);

            return [$clean => [
                'command' => $event->command,
                'expression' => $event->expression,
            ]];
        });
    }

    public function getCommands(): \Illuminate\Support\Collection
    {
        $commands = collect();

        // Scan command files in the specified folders
        foreach ($this->getFolders() as $namespace => $folder) {
            $files = scandir($folder);

            foreach ($files as $file) {
                if (is_file($folder.'/'.$file)) {
                    $parts = explode('.', $file);
                    $filename = $parts[0];
                    $fullyQualifiedClassName = $namespace.'\\'.$filename;

                    try {
                        $reflection = new \ReflectionClass($fullyQualifiedClassName);
                        $property = $reflection->getProperty('signature');
                        $property->setAccessible(true);

                        $commandInstance = new $fullyQualifiedClassName;
                        $signature = $property->getValue($commandInstance);

                        $commands->put($signature, [
                            'command' => $fullyQualifiedClassName,
                            'description' => $commandInstance->getDescription(),
                        ]);

                    } catch (\Throwable $e) {
                        throw new \RuntimeException($e->getMessage());
                    }

                }
            }
        }

        return $commands;
    }

    public function getFolders(): array
    {
        return config('jobrunner.folders');
    }
}
