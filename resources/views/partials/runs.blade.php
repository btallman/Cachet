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
                                    @include('partials.run', ['run' => $run])
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <p style="padding: 5px">{{ trans('cachet.incidents.none') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>