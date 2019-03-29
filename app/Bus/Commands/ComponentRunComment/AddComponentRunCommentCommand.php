<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Commands\ComponentRunComment;

final class AddComponentRunCommentCommand
{
    /**
     * The component run comment text.
     *
     * @var string
     */
    public $comment;

    /**
     * The component run comment type.
     *
     * @var int
     */
    public $type;

    /**
     * The component run.
     *
     * @var int
     */
    public $component_run_id;

    /**
     * The component run comment user id.
     *
     * @var int
     */
    public $user_id;

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'comment'        => 'required|string',
        'type'      => 'int|min:0|max:4',
        'component_run_id'    => 'required|int',
        'user_id'        => 'required|int',
    ];

    /**
     * Create a new add component run comment command instance.
     *
     * @param string $comment
     * @param int    $type
     * @param int    $component_run_id
     * @param int    $user_id
     *
     * @return void
     */
    public function __construct($comment, $type, $component_run_id, $user_id)
    {
        $this->comment = $comment;
        $this->type = (int) $type;
        $this->component_run_id = (int) $component_run_id;
        $this->user_id = (int) $user_id;
    }
}
