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

use CachetHQ\Cachet\Bus\Commands\ComponentRun\UpdateComponentRunCommand;
use CachetHQ\Cachet\Bus\Events\ComponentRun\ComponentRunWasUpdatedEvent;
use CachetHQ\Cachet\Models\ComponentRun;

class UpdateComponentRunCommandHandler
{
    /**
     * Handle the update component run command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Component\UpdateComponentRunCommand $command
     *
     * @return \CachetHQ\Cachet\Models\ComponentRun
     */
    public function handle(UpdateComponentRunCommand $command)
    {
        $component_run = $command->component_run;

        $component_run->update($this->filter($command));

        event(new ComponentRunWasUpdatedEvent($component_run));

        return $component_run;
    }

    /**
     * Filter the command data.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Incident\UpdateComponentRunCommand $command
     *
     * @return array
     */
    protected function filter(UpdateComponentRunCommand $command)
    {
        $params = [
            'name'        => $command->name,
            'description' => $command->description,
            'link'        => $command->link,
            'status'      => $command->status,
            'component_id'    => $command->component_id
        ];

        return array_filter($params, function ($val) {
            return $val !== null;
        });
    }
}
