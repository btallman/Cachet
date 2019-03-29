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

final class AddComponentRunCommand
{
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
     * The component run status.
     *
     * @var string
     */
    public $status;

    /**
     * The component run link.
     *
     * @var string
     */
    public $link;

    /**
     * The component.
     *
     * @var int
     */
    public $component_id;

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
        'name'        => 'required|string',
        'description' => 'string',
        'status'      => 'int|min:0|max:4',
        'link'        => 'url',
        'component_id'    => 'required|int',
        'airflow'     => 'url'        
    ];

    /**
     * Create a new add component run command instance.
     *
     * @param string $name
     * @param string $description
     * @param int    $status
     * @param string $link
     * @param int    $component_id
     * @param string $airflow
     *
     * @return void
     */
    public function __construct($name, $description, $status, $link, $component_id, $airflow)
    {
        $this->name = $name;
        $this->description = $description;
        $this->status = (int) $status;
        $this->link = $link;
        $this->component_id = $component_id;
        $this->airflow = $airflow;
    }
}
