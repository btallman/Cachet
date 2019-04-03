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

use CachetHQ\Cachet\Bus\Commands\ComponentRun\AddComponentRunCommand;
use CachetHQ\Cachet\Bus\Commands\ComponentRun\RemoveComponentRunCommand;
use CachetHQ\Cachet\Bus\Commands\ComponentRun\UpdateComponentRunCommand;
use CachetHQ\Cachet\Models\ComponentRun;
use CachetHQ\Cachet\Models\Component;
use CachetHQ\Cachet\Models\Tag;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ComponentRunController extends AbstractApiController
{
    /**
     * Get all components.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponentRuns(Component $component)
    {

        $component_runs = $component->runs();

        if ($sortBy = Binput::get('sort')) {
            $direction = Binput::has('order') && Binput::get('order') == 'desc';

            $component_runs->sort($sortBy, $direction);
        }

        $component_runs = $component_runs->paginate(Binput::get('per_page', 20));

        return $this->paginator($component_runs, Request::instance());
    }

    /**
     * Get a single component.
     *
     * @param \CachetHQ\Cachet\Models\Component $component
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponentRun(ComponentRun $component_run)
    {
        return $this->item($component_run);
    }

    /**
     * Get a component run's comments.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponentRunComments(ComponentRun $component_run)
    {
        $component_run_comments = $component_run->comments();

        if ($sortBy = Binput::get('sort')) {
            $direction = Binput::has('order') && Binput::get('order') == 'desc';

            $component_run_comments->sort($sortBy, $direction);
        }

        $component_run_comments = $component_run_comments->paginate(Binput::get('per_page', 20));

        return $this->paginator($component_run_comments, Request::instance());

    }
    
    
    /**
     * Get a single component run's last comment.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponendRunCommentLast(ComponentRun $component_run)
    {   
        $comment = $component_run->last_comment();
        return $this->item($comment);
    }

    /**
     * Create a new component run.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postComponentRun()
    {
        try {
            $component_run = dispatch(new AddComponentRunCommand(
                Binput::get('name'),
                Binput::get('description'),
                Binput::get('status'),
                Binput::get('link'),
                Binput::get('component_id'),
                Binput::get('airflow')
            ));
        } catch (QueryException $e) {
            throw new BadRequestHttpException();
        }

        return $this->item($component_run);
    }

    /**
     * Update an existing component run.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function putComponentRun(ComponentRun $component_run)
    {
        try {
            dispatch(new UpdateComponentRunCommand(
                $component_run,
                Binput::get('name'),
                Binput::get('description'),
                Binput::get('status'),
                Binput::get('link'),
                Binput::get('component_id'),
                Binput::get('airflow')
            ));
        } catch (QueryException $e) {
            throw new BadRequestHttpException();
        }

        return $this->item($component_run);
    }

    /**
     * Delete an existing component run.
     *
     * @param \CachetHQ\Cachet\Models\ComponentRun $component_run
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComponentRun(ComponentRun $component_run)
    {
        dispatch(new RemoveComponentRunCommand($component_run));

        return $this->noContent();
    }
}
