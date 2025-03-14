<?php

namespace BeInteractive\Jobrunner;

class Jobrunner
{
    /**
     * Get all the commands that are scheduled to run
     *
     * @return \Illuminate\Support\Collection<string, array{command: string, expression: string}>
     */
    public function getScheduledCommands(): \Illuminate\Support\Collection
    {
        return collect(
            app('Illuminate\Console\Scheduling\Schedule')->events()
        )
            ->filter(function ($event) {
                return ! empty($event->command);
            })
            ->mapWithKeys(function ($event) {
                // remove the command signature from the command string
                $parts = explode(' ', $event->command);
                $clean = array_pop($parts);

                return [$clean => [
                    'command' => (string) $event->command,
                    'expression' => (string) $event->expression,
                ]];
            });
    }

    /**
     * Get all the commands that are available
     *
     * @return \Illuminate\Support\Collection<string, array{command: string, description: string}>
     */
    public function getCommands(): \Illuminate\Support\Collection
    {
        $commands = collect();

        // Scan command files in the specified folders
        $folders = $this->getFolders();
        if (is_null($folders)) {
            throw new \RuntimeException('No folders specified');
        }

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

    /**
     * Get the folders where the commands are located
     *
     * @return array<int, string>|null
     */
    public function getFolders(): ?array
    {
        $folders = config('jobrunner.folders');

        if (is_array($folders) && count($folders) > 0) {
            return $folders;

        }

        return null;
    }
}
