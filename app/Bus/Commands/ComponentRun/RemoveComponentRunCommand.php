<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Commands\ComponentRun;

use CachetHQ\Cachet\Models\ComponentRun;

final class RemoveComponentRunCommand
{
    /**
     * The component to remove.
     *
     * @var \CachetHQ\Cachet\Models\Component
     */
    public $component_run;

    /**
     * Create a new remove component run command instance.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     *
     * @return void
     */
    public function __construct(ComponentRun $component_run)
    {
        $this->component_run = $component_run;
    }
}
