<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Events\ComponentRun;

use CachetHQ\Cachet\Models\ComponentRun;

final class ComponentRunWasAddedEvent implements ComponentRunEventInterface
{
    /**
     * The component run that was added.
     *
     * @var \CachetHQ\Cachet\Models\ComponentRun
     */
    public $component_run;

    /**
     * Create a new component run was added event instance.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     *
     * @return void
a     */
    public function __construct(ComponentRun $component_run)
    {
        $this->component_run = $component_run;
    }
}
