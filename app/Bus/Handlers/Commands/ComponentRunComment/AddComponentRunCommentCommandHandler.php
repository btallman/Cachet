<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Handlers\Commands\ComponentRunComment;

use CachetHQ\Cachet\Bus\Commands\ComponentRunComment\AddComponentRunCommentCommand;
use CachetHQ\Cachet\Bus\Events\ComponentRun\ComponentRunWasUpdatedEvent;
use CachetHQ\Cachet\Models\ComponentRunComment;

class AddComponentRunCommentCommandHandler
{
    /**
     * Handle the add component run comment command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Component\AddComponentRunCommentCommand $command
     *
     * @return \CachetHQ\Cachet\Models\ComponentRunComment
     */
    public function handle(AddComponentRunCommentCommand $command)
    {
        $component_run_comment = ComponentRunComment::create($this->filter($command));

        // event(new ComponentRunWasUpdatedEvent($component_run_comment->component_run()));

        return $component_run_comment;
    }

    /**
     * Filter the command data.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Incident\AddComponentCommentCommand $command
     *
     * @return array
     */
    protected function filter(AddComponentRunCommentCommand $command)
    {
        \Log::debug($command->comment);
        \Log::debug($command->type);
        \Log::debug($command->component_run_id);
        \Log::debug('User: '.$command->user_id);
        $params = [
            'comment'        => $command->comment,
            'type'           => $command->type,
            'component_run_id' => $command->component_run_id,
            'user_id'        => $command->user_id
        ];

        return array_filter($params, function ($val) {
            return $val !== null;
        });
    }
}
