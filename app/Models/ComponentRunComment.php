<?php

namespace CachetHQ\Cachet\Models;

use Illuminate\Database\Eloquent\Model;
use AltThree\Validator\ValidatingTrait;
use CachetHQ\Cachet\Models\Traits\SearchableTrait;
use CachetHQ\Cachet\Models\Traits\SortableTrait;
use CachetHQ\Cachet\Presenters\ComponentRunCommentPresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;

class ComponentRunComment extends Model implements HasPresenter
{
    use SearchableTrait, SoftDeletes, SortableTrait, ValidatingTrait;

    /**
     * The fillable properties.
     *
     * @var string[]
     */
    protected $fillable = [
        'component_run_id',
        'type',
        'comment',
        'user_id',
        'created_at'
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'component_run_id' => 'int',
        'user_id'          => 'required|int',
        'comment'          => 'required',
    ];
    
    /**
     * The sortable fields.
     *
     * @var string[]
     */
    protected $sortable = [
        'id',
        'component_run_id',
        'comment',
        'type',
        'created_at',
        'user_id',
    ];
    
    /**
     * A comment belongs to a user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }
    
    /**
     * A comment belongs to a component run.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function component_run()
    {
        return $this->belongsTo(ComponentRun::class, 'component_run_id', 'id');
    }

    public function getPresenter()
    {
        return new ComponentRunCommentPresenter($this);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return ComponentRunCommentPresenter::class;
    }

}
