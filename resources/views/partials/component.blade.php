<li style="padding:7px" class="list-group-item {{ $component->group_id ? "sub-component" : "component" }}">
    <div class="pull-right">
        <small class="text-component-{{ $component->status }} {{ $component->status_color }}" data-toggle="tooltip" title="{{ trans('cachet.components.last_updated', ['timestamp' => $component->updated_at_formatted]) }}">{{ $component->human_status }}</small>
    </div>
    <a onclick="toggleOutline(this)" data-toggle="collapse" href="#component_description_{{ $component->id }}" style="text-decoration: none;" role="button" aria-expanded="false" aria-controls="#component_description_{{ $component->id }}">
        <i class="ion-ios-plus-outline"></i> {{ $component->name }}@if( $component->short_desc) - {{ $component->short_desc }}@endif
        @if($component->last_run)
         @php
            $last_run = $component->last_run->getPresenter();
        @endphp
        <span class="pull-right" data-toggle="tooltip" title="{{ trans('cachet.component_runs.last_run', ['timestamp' => $last_run->created_at_formatted]) }}">{{ $last_run->created_at_diff }}&nbsp;</span>@endif
    </a>
    <div style="margin-left: 25px; margin-top: 0px;" class="collapse" id="component_description_{{ $component->id }}">
        <div class="container" style="width:862px;">
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs" id="detail_tabs_{{ $component->id }}" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="description-tab_{{ $component->id }}" data-toggle="tab" href="#description_{{ $component->id }}" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="runs-tab_{{ $component->id }}" data-toggle="tab" href="#runs_{{ $component->id }}" role="tab" aria-controls="runs" aria-selected="false">Runs</a>    
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="incidents-tab_{{ $component->id }}" data-toggle="tab" href="#incidents_{{ $component->id }}" role="tab" aria-controls="incidents_{{ $component->id }}" aria-selected="false">Incidents</a>    
                    </li>
                </ul>
                    <div class="tab-content" style="margin:5px;border:1px;" id="detail_tabs_{{ $component->id }}Content">
                        <div class="tab-pane active" id="description_{{ $component->id }}" role="tabpanel" aria-labelledby="description-tab_{{ $component->id }}">
                            @if($component->description)
                                {!! $component->formattedDescription() !!}
                            @else
                                {{  $component->short_desc }}
                            @endif
                            
                            <ul id="component-detail-links_{{ $component->id }}" class="nav nav-pills">
                            @if($current_user->isAdmin)
                                <li class="nav-item"><a href="/dashboard/components/{{ $component->id }}/edit" class="btn btn-linkt">{{ trans('forms.edit') }} Component</a></li>
                            @endif
                            @if($component->link)
                                <li class="nav-item"><a href="{{ $component->link }}" target="_blank" class="btn btn-link">Confluence Docs</a></li>
                            @else
                                <li class="nav-item">No Docs</li>
                            @endif
                            @if($component->airflow)
                                <li class="nav-item"><a href="{{ $component->airflow }}" target="_blank" class="btn btn-link">Airflow DAG</a></li>
                            @endif
                            </ul>
                        </div>
                      
                        <div class="tab-pane fade" id="runs_{{ $component->id }}" role="tabpanel" aria-labelledby="profile-tab_{{ $component->id }}">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Status</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Run At</th>
                                        <th scope="col">Updates</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($component->runs as $runID => $run)
                                @php
                                    $run = $run->getPresenter();
                                    $comments = $run->comments;
                                    $last_comment = $run->last_comment;
                                    if($last_comment){
                                        $last_comment = $last_comment->getPresenter();
                                        $comment_popup = "";
                                        foreach($comments as $comment) {
                                            $comment = $comment->getPresenter();
                                            $comment_popup .= '<div align="left">'.$comment->created_at_formatted." - ".$comment->comment . "</p>";
                                        }
                                    }else{
                                        $comment_popup = "NO WAY MAN!";
                                    }
                                @endphp
                                    <tr>
                                        <td scope="row">
                                            <div class="status-icon status-{{ $run->status }}" data-toggle="tooltip" title="{{ $run->human_status }}" data-placement="left">
                                                <i class="{{ $run->icon }}"></i>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $run->name }}
                                        </td>
                                        <td>
                                            {{ $run->description }}
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="{{ $run->created_at_diff }}">{{ $run->created_at }}</span>
                                        </td>
                                        <td>
                                            @if($last_comment)
                                                <span data-toggle="tooltip" data-html="true" title="{{ $comment_popup }}">{!! $last_comment->formattedComment !!}</span>
                                            @else
                                                <span>No Comments</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ $run->airflow }}" target="_blank">Airflow</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <p style="padding: 5px">{{ trans('cachet.incidents.none') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="incidents_{{ $component->id }}" role="tabpanel" aria-labelledby="profile-tab_{{ $component->id }}">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Status</th>
                                        <th scope="col">Incident</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($component->incidents as $incidentID => $incident)
                                @php
                                    $incident = $incident->getIncidentPresenter();
                                @endphp
                                    <tr>
                                        <td scope="row">
                                            <div class="status-icon status-{{ $incident->status }}" data-toggle="tooltip" title="{{ $incident->human_status }}" data-placement="left">
                                                <i class="{{ $incident->icon }}"></i>
                                            </div>
                                        </td>
                                        <td>
                                            @include('partials.incident', ['incident' => $incident, 'with_link' => true])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <p style="padding: 5px">{{ trans('cachet.incidents.none') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</li>
