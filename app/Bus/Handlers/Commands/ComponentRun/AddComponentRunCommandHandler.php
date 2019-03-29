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

use CachetHQ\Cachet\Bus\Commands\ComponentRun\AddComponentRunCommand;
use CachetHQ\Cachet\Bus\Events\ComponentRun\ComponentRunWasAddedEvent;
use CachetHQ\Cachet\Models\ComponentRun;

class AddComponentRunCommandHandler
{
    /**
     * Handle the add component run command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Component\AddComponentRunCommand $command
     *
     * @return \CachetHQ\Cachet\Models\ComponentRun
     */
    public function handle(AddComponentRunCommand $command)
    {
        $component_run = ComponentRun::create($this->filter($command));

        event(new ComponentRunWasAddedEvent($component_run));

        return $component_run;
    }

    /**
     * Filter the command data.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Incident\AddComponentCommand $command
     *
     * @return array
     */
    protected function filter(AddComponentRunCommand $command)
    {
        $params = [
            'name'        => $command->name,
            'description' => $command->description,
            'link'        => $command->link,
            'status'      => $command->status,
            'component_id'=> $command->component_id,
            'airflow'     => $command->airflow
        ];

        return array_filter($params, function ($val) {
            return $val !== null;
        });
    }
}
