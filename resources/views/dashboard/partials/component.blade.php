<li class="list-group-item {{ $component->group_id ? "sub-component" : "component" }}">
    <form class='component-inline form-vertical' data-messenger="{{trans('dashboard.components.edit.success')}}">
        <div style="margin-left: 25px;" class="row striped-list-item">
            <div class="col-lg-4 col-md-3 col-sm-12">
                <h4 class="{{ $component->status_color }}">{{ $component->name }}</h5>
                <div style="margin-left: 25px;">@if($component->description) {!! $component->formattedDescription() !!} @endif</div>
            </div>
            <div class="col-lg-8 col-md-9 col-sm-12 radio-items component-inline-update">
                @foreach(trans('cachet.components.status') as $statusID => $status)
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="status" value="{{ $statusID }}" {{ (int) $component->status === $statusID ? 'checked' : null }}>
                        {{ $status }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <input type="hidden" name="component_id" value="{{ $component->id }}">
    </form>
</li>
