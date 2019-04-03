                            @if($component->description)
                                {!! $component->formattedDescription() !!}
                            @else
                                {{  $component->short_desc }}
                            @endif
