<?php

use BeInteractive\Jobrunner\Facades\Jobrunner;

it('can find scheduled commands', function () {
    $commands = Jobrunner::getScheduledCommands();

    expect($commands->count())->toBe(1)
        ->and($commands->keys())->toContain('test:command');

});
