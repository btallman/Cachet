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

class ComponentRunPresenter extends BasePresenter implements Arrayable
{
    use TimestampsTrait;

    /**
     * Renders the message from Markdown into HTML.
     *
     * @return string
     */
    public function formattedDescription()
    {
        return Markdown::convertToHtml($this->wrappedObject->description);
    }

    /**
     * Present diff for humans date time.
     *
     * @return string
     */
    public function created_at_diff()
    {
        return app(DateFactory::class)->make($this->wrappedObject->created_at)->diffForHumans();
    }

    /**
     * Present formatted date time.
     *
     * @return string
     */
    public function created_at_formatted()
    {
        return ucfirst(app(DateFactory::class)->make($this->wrappedObject->created_at)->format(Config::get('setting.incident_date_format', 'l jS F Y H:i:s')));
    }

    /**
     * Formats the created_at time ready to be used by bootstrap-datetimepicker.
     *
     * @return string
     */
    public function created_at_datetimepicker()
    {
        return app(DateFactory::class)->make($this->wrappedObject->created_at)->format('d/m/Y H:i');
    }

    /**
     * Present formatted date time.
     *
     * @return string
     */
    public function created_at_iso()
    {
        return app(DateFactory::class)->make($this->wrappedObject->created_at)->toISO8601String();
    }

    /**
     * Returns a formatted timestamp for use within the timeline.
     *
     * @return string
     */
    public function timestamp_formatted()
    {
        return $this->created_at_formatted;
    }

    /**
     * Return the iso timestamp for use within the timeline.
     *
     * @return string
     */
    public function timestamp_iso()
    {
        return $this->created_at_iso;
    }

    /**
     * Present the status with an icon.
     *
     * @return string
     */
    public function icon()
    {
        switch ($this->wrappedObject->status) {
            case 0: // Success
                return 'icon ion-checkmark greens';
            case 1: // Failed
                return 'icon ion-flag oranges';
            default: // Something actually broke, this shouldn't happen, but not a failed run.
                return 'icon ion-checkmark greens';;
        }
    }

    /**
     * Returns a human readable version of the status.
     *
     * @return string
     */
    public function human_status()
    {
        return trans('cachet.component_runs.status.'.$this->wrappedObject->status);
    }

    /**
     * Convert the presenter instance to an array.
     *
     * @return string[]
     */
    public function toArray()
    {
        return array_merge($this->wrappedObject->toArray(), [
            'human_status' => $this->human_status(),
            'icon'         => $this->icon(),
            'formatted_description' => $this->formattedDescription()
        ]);
    }
}
