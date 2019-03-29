<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Models;

use AltThree\Validator\ValidatingTrait;
use CachetHQ\Cachet\Models\Traits\SearchableTrait;
use CachetHQ\Cachet\Models\Traits\SortableTrait;
use CachetHQ\Cachet\Presenters\ComponentRunPresenter;
use CachetHQ\Cachet\Presenters\ComponentRunCommentPresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;

class ComponentRun extends Model implements HasPresenter
{
    use SearchableTrait, SoftDeletes, SortableTrait, ValidatingTrait;

    /**
     * The fillable properties.
     *
     * @var string[]
     */
    protected $fillable = [
        'component_id',
        'name',
        'status',
        'description',
        'created_at',
        'link'
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'component_id' => 'int',
        'name'         => 'required',
        'status'       => 'required|int',
        'link'         => 'url'
    ];

    /**
     * The searchable fields.
     *
     * @var string[]
     */
    protected $searchable = [
        'id',
        'component_id',
        'name',
        'status',
        'description',
        'created_at',
        'link'
    ];

    /**
     * The sortable fields.
     *
     * @var string[]
     */
    protected $sortable = [
        'id',
        'component_id',
        'name',
        'status',
        'created_at',
        'link'
    ];

    /**
     * An incident belongs to a component.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function component()
    {
        return $this->belongsTo(Component::class, 'component_id', 'id');
    }

    /**
     * Lookup all of the Runs reported on the component.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(ComponentRunComment::class, 'component_run_id', 'id')->orderBy('created_at', 'DESC');
    }

    /**
     * Lookup the last Run reported on the component.
     *
     * @return \CachetHQ\Cachet\Models\ComponentRunComment
     */
    public function last_comment()
    {   
        $list = $this->comments()->latest()->first();
        
        return $list;
    }


    public function getPresenter()
    {
        return new ComponentRunPresenter($this);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return ComponentRunPresenter::class;
    }
}
