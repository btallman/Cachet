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

final class UpdateComponentRunCommand
{
    /**
     * The component to update.
     *
     * @var \CachetHQ\Cachet\Models\Component
     */
    public $component_run;

    /**
     * The component name.
     *
     * @var string
     */
    public $name;

    /**
     * The component description.
     *
     * @var string
     */
    public $description;

    /**
     * The component status.
     *
     * @var int
     */
    public $status;

    /**
     * The component link.
     *
     * @var string
     */
    public $link;

    /**
     * The airflow dag link.
     *
     * @var string
     */
    public $airflow;
    
    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'name'        => 'string',
        'description' => 'string',
        'status'      => 'int|min:1|max:4',
        'link'        => 'url',
        'component_id'    => 'int',
        'airflow'     => 'url'
    ];

    /**
     * Create a new update component run command instance.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     * @param string                            $name
     * @param string                            $description
     * @param int                               $status
     * @param string                            $link
     * @param int                               $component_id
     * @param string                            $airflow
     *
     * @return void
     */
    public function __construct(ComponentRun $component_run, $name, $description, $status, $link, $component_id, $airflow)
    {
        $this->component_run = $component_run;
        $this->name = $name;
        $this->description = $description;
        $this->status = (int) $status;
        $this->link = $link;
        $this->component_id = $component_id;
        $this->airflow = $airflow;
    }
}
