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
        <span class="pull-right">{{ $last_run->created_at_diff }}&nbsp;</span>@endif
    </a>
    <div style="margin-left: 25px; margin-top: 0px;" class="collapse" id="component_description_{{ $component->id }}">
        <div class="card">
            <div class="card-body">
                @if($component->description) <div style="margin-top:5px;">{!! $component->formattedDescription() !!}</div>@endif
                  <div style="margin-top: 10px; margin-bottom:5px;" class="timeline">
                        <div class="content-wrapper">
                            @forelse($component->incidents as $incidentID => $incident)
                            @php
                                $incident = $incident->getIncidentPresenter();
                            @endphp
                            <div class="moment {{ $incidentID === 0 ? 'first' : null }}">
                                <div class="row event clearfix">
                                    <div class="col-sm-1">
                                        <div class="status-icon status-{{ $incident->status }}" data-toggle="tooltip" title="{{ $incident->human_status }}" data-placement="left">
                                            <i class="{{ $incident->icon }}"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-2 col-sm-11 col-sm-offset-0">
                                        @include('partials.incident', ['incident' => $incident, 'with_link' => true])
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="panel panel-message incident">
                                <div class="panel-body">
                                    <p style="padding: 5px">{{ trans('cachet.incidents.none') }}</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                @if($current_user->isAdmin)
                <div class="pull-right"><a href="/dashboard/components/{{ $component->id }}/edit" class="btn btn-default">{{ trans('forms.edit') }}</a><a href="/dashboard/components/{{ $component->id }}/delete" class="btn btn-danger confirm-action" data-method="DELETE">{{ trans('forms.delete') }}</a></div>
                @endif
                @if($component->link) <a href="{{ $component->link }}" target="_blank" class="btn btn-link">Confluence</a>@else No Docs @endif
                <br />
                <br />
              </div>
        </div>
    </div>

</li>
