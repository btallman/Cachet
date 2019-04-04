@php
    if($component->last_run){
        $last_run = $component->last_run->getPresenter();
    } else {
        $last_run = false;
    }
@endphp
<li style="padding:7px" class="list-group-item {{ $component->group_id ? "sub-component" : "component" }}">
    <div class="pull-right" style="width:200px;">
        <div class="pull-right"><small class="text-component-{{ $component->status }} {{ $component->status_color }}" data-toggle="tooltip" title="{{ trans('cachet.components.last_updated', ['timestamp' => $component->updated_at_formatted]) }}">{{ $component->human_status }}</small></div>
        @if($last_run)<div class="pull-left" data-toggle="tooltip" title="{{ trans('cachet.component_runs.last_run', ['timestamp' => $last_run->created_at_formatted]) }}">{{ $last_run->created_at_diff }}</div>@endif
    </div>
    <a onclick="toggleOutline(this)" data-toggle="collapse" href="#component_description_{{ $component->id }}" style="text-decoration: none;" role="button" aria-expanded="false" aria-controls="#component_description_{{ $component->id }}">
        <i class="ion-ios-plus-outline"></i> {{ $component->name }}@if( $component->short_desc) - {{ $component->short_desc }}@endif
    </a>
    <div style="margin-left: 25px; margin-top: 0px;" class="collapse" id="component_description_{{ $component->id }}">
        <div class="container" style="width:862px;">
            <div class="row">
                <div class="col" style="margin-top: 5px;">
                    <ul class="nav nav-tabs" id="detail_tabs_{{ $component->id }}" role="tablist">
                    @if($component->group->supports_runs)
                    <li class="nav-item active">
                        <a class="nav-link" id="runs-tab_{{ $component->id }}" data-toggle="tab" href="#runs_{{ $component->id }}" role="tab" aria-controls="runs" aria-selected="false">Runs</a>    
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link@if(!$component->group->supports_runs) active@endif" id="incidents-tab_{{ $component->id }}" data-toggle="tab" href="#incidents_{{ $component->id }}" role="tab" aria-controls="incidents_{{ $component->id }}" aria-selected="false">Incidents</a>    
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="description-tab_{{ $component->id }}" data-toggle="tab" href="#description_{{ $component->id }}" role="tab" aria-controls="description" aria-selected="true">Documentation</a>
                    </li>
                </ul>
                    <div class="tab-content" style="padding:10px;margin:0px;border:1px solid #ccc;height: 250px;overflow:auto;" id="detail_tabs_{{ $component->id }}Content">
                        @if($component->group->supports_runs)
                        <div class="tab-pane active" id="runs_{{ $component->id }}" role="tabpanel" aria-labelledby="profile-tab_{{ $component->id }}">
                            @include('partials.runs', ['component' => $component])
                        </div>
                        @endif

                        <div class="tab-pane @if($component->group->supports_runs) fade @else active @endif" id="incidents_{{ $component->id }}" role="tabpanel" aria-labelledby="profile-tab_{{ $component->id }}">
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

                        <div class="tab-pane fade" id="description_{{ $component->id }}" role="tabpanel" aria-labelledby="description-tab_{{ $component->id }}">
                            @include('partials.documentation', ['component' => $component])
                        </div>

                    </div>
                    
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
                        @else
                            <li class="nav-item"><a href="Javascript: alert('No DAG configured');">No DAG</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

</li>
