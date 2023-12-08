@php
    use App\Classes\Enum\ProjectStatusEnum;
@endphp
@extends('layouts.app')

@section('template_linked_css')
@endsection

@section('page_title')
    <li class="breadcrumb-item">
        <span>Project</span>
    </li>
@endsection

@section('content')
    <div class="row justify-content-end">
        <div class="col-2 d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProject">Add
                project</button>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($projects as $project)
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="col-sm-4">
                            <img src="{{ asset('images/folder.jpg') }}" alt="" width="100%">
                        </div>
                        <div class="col-sm-8 ps-3">
                            <h5>{{ $project->name }}</h5>
                            <button type="button" data-project-id="{{ $project->id }}" class="btn btn-success pull-project"
                                @if ($project->status == ProjectStatusEnum::OFF->value)
                                    disabled
                                @endif
                                >Git pull</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProject">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('project.register') }}" method="post" class="modal-body" id="form-create-project">
                    @csrf
                    @foreach ($statusProject as  $status)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" @if ( $status['value'] == ProjectStatusEnum::ON->value) checked @endif type="radio" name="status" id="status{{ $status['name'] }}"
                                value="{{ $status['value'] }}">
                            <label class="form-check-label" for="status{{ $status['name'] }}">{{ $status['name'] }}</label>
                        </div>
                    @endforeach
                    <div class="form-floating mt-4">
                        <input class="form-control" id="name_project" name="name">
                        <label for="name_project">Name project</label>
                    </div>
                    <div class="form-floating mt-4">
                        <input class="form-control" id="link_folder" name="link_folder">
                        <label for="link_folder">Link folder</label>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_new_project">Save</button>
                </div>
            </div>
        </div>
    </div>
    @include('modal.error')
@endsection

@section('script_js')
    <script>
        $(document).ready(function() {
            $(document).on("click", "#save_new_project", function() {
                $('#form-create-project').submit();
            });

            $(document).on("click", ".pull-project", function() {
                $('#modal-command').modal('show');
                $('#text-command').text('');
                var project_id = $(this).attr('data-project-id');

                // Start listening for events
                var eventSource = new EventSource(`{{ route('project.gitPull') }}?project_id=${project_id}`);

                // Handle messages received
                eventSource.onmessage = function(event) {
                    console.log(event.data); // Logging each line of output

                    // Append each line of output to the command output div
                    $('#text-command').append(`${event.data}\n`);
                };

                eventSource.onerror = function(error) {
                    // Handle any errors that occur
                    console.error('EventSource failed:', error);
                    eventSource.close();
                };
            });
        });
    </script>
@endsection
