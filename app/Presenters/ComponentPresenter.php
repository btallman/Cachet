<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Presenters;

use CachetHQ\Cachet\Dates\DateFactory;
use CachetHQ\Cachet\Presenters\Traits\TimestampsTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Config;
use McCool\LaravelAutoPresenter\BasePresenter;

class ComponentPresenter extends BasePresenter implements Arrayable
{
    use TimestampsTrait;

    /**
     * Returns the override class name for theming.
     *
     * @return string
     */
    public function status_color()
    {
        switch ($this->wrappedObject->status) {
            case 1: return 'greens';
            case 2: return 'blues';
            case 3: return 'yellows';
            case 4: return 'reds';
        }
    }

    /**
     * Looks up the human readable version of the status.
     *
     * @return string
     */
    public function human_status()
    {
        return trans('cachet.components.status.'.$this->wrappedObject->status);
    }

    /**
     * Find all tag names for the component names.
     *
     * @return array
     */
    public function tags()
    {
        return $this->wrappedObject->tags->pluck('name', 'slug');
    }

    /**
     * Present formatted date time.
     *
     * @return string
     */
    public function updated_at_formatted()
    {
        return ucfirst(app(DateFactory::class)->make($this->wrappedObject->updated_at)->format(Config::get('setting.incident_date_format', 'l jS F Y H:i:s')));
    }

    /**
     * Present formatted date time.
     *
     * @return string
     */
    public function last_run_formatted()
    {

        if($this->wrappedObject->last_run){
            return ucfirst(app(DateFactory::class)->make($this->wrappedObject->last_run)->format(Config::get('setting.incident_date_format', 'Y-m-d H:i')));
        }else{
            return null;
        }
    }

    /**
     * Formats the last_run time ready to be used by bootstrap-datetimepicker.
     *
     * @return string
     */
    public function last_run_datetimepicker()
    {
        return app(DateFactory::class)->make($this->wrappedObject->last_run)->format('d/m/Y H:i');
    }

    /**
     * Convert the presenter instance to an array.
     *
     * @return string[]
     */
    public function toArray()
    {
        return array_merge($this->wrappedObject->toArray(), [
            'created_at'  => $this->created_at(),
            'updated_at'  => $this->updated_at(),
            'status_name' => $this->human_status(),
            'tags'        => $this->tags(),
        ]);
    }
    
     /**
     * Renders the description from Markdown into HTML.
     *
     * @return string
     */
    public function formattedDescription()
    {
        return Markdown::convertToHtml($this->wrappedObject->description);
    }

}
