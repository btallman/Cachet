<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Http\Controllers\Api;

use CachetHQ\Cachet\Bus\Commands\ComponentRunComment\AddComponentRunCommentCommand;
use CachetHQ\Cachet\Models\ComponentRunComment;
use CachetHQ\Cachet\Models\ComponentRun;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ComponentRunCommentController extends AbstractApiController
{

    /**
     * Get a single component run comment.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRunComment $component_run_comment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponentRunComment(ComponentRunComment $component_run_comment)
    {
        return $this->item($component_run_comment);
    }

    /**
     * Create a new component run comment.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postComponentRunComment()
    {
        try {
            $component_run_comment = dispatch(new AddComponentRunCommentCommand(
                Binput::get('comment'),
                Binput::get('type'),
                Binput::get('component_run_id'),
                \Auth::user()->id
            ));
        } catch (QueryException $e) {
            throw new BadRequestHttpException();
        }

        return $this->item($component_run_comment);
    }

}