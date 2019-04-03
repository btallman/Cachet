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
                                            @if($run->airflow)
                                                <a href="{{ $run->airflow }}" target="_blank">Airflow</a>
                                            @else
                                                <a href="Javascript: alert('No DagRun linked');">Airflow</a>
                                            @endif
                                        </td>
                                    </tr>