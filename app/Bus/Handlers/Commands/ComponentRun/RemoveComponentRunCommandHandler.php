<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Handlers\Commands\ComponentRun;

use CachetHQ\Cachet\Bus\Commands\ComponenRunt\RemoveComponentRunCommand;
use CachetHQ\Cachet\Bus\Events\ComponentRun\ComponentRunWasRemovedEvent;

class RemoveComponentRunCommandHandler
{
    /**
     * Handle the remove component run command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Component\RemoveComponentRunCommand $command
     *
     * @return void
     */
    public function handle(RemoveComponentRunCommand $command)
    {
        $component_run = $command->component_run;

        event(new ComponentRunWasRemovedEvent($component_run));

        $component_run->delete();
    }
}
