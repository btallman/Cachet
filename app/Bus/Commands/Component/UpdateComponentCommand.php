<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Commands\Component;

use CachetHQ\Cachet\Models\Component;

final class UpdateComponentCommand
{
    /**
     * The component to update.
     *
     * @var \CachetHQ\Cachet\Models\Component
     */
    public $component;

    /**
     * The component name.
     *
     * @var string
     */
    public $name;

    /**
     * The component short description.
     *
     * @var string
     */
    public $short_desc;
    
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
     * The component order.
     *
     * @var int
     */
    public $order;

    /**
     * The component group.
     *
     * @var int
     */
    public $group_id;

    /**
     * Is the component enabled?
     *
     * @var bool
     */
    public $enabled;
    
    /**
     * Last time the component was run?
     * 
     * @var string|null
     */
     public $schedule;

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
        'order'       => 'int',
        'group_id'    => 'int',
        'enabled'     => 'bool',
        'schedule'    => 'string|null',
        'short_desc'  => 'string|null',
        'airflow'     => 'string'
    ];

    /**
     * Create a new update component command instance.
     *
     * @param \CachetHQ\Cachet\Models\Component $component
     * @param string                            $name
     * @param string                            $description
     * @param int                               $status
     * @param string                            $link
     * @param int                               $order
     * @param int                               $group_id
     * @param bool                              $enabled
     * @param string                            $schedule
     * @param string                            $short_desc
     * @param airflow                           $airflow
     *
     * @return void
     */
    public function __construct(Component $component, $name, $description, $status, $link, $order, $group_id, $enabled, $schedule, $short_desc, $airflow)
    {
        $this->component = $component;
        $this->name = $name;
        $this->description = $description;
        $this->status = (int) $status;
        $this->link = $link;
        $this->order = $order;
        $this->group_id = $group_id;
        $this->enabled = $enabled;
        $this->schedule = $schedule;
        $this->short_desc = $short_desc;
        $this->airflow = $airflow;
    }
}
