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
                            <div class="col-12">
                                <button type="button" data-project-id="{{ $project->id }}"
                                    class="btn btn-success pull-project"
                                    @if ($project->status == ProjectStatusEnum::OFF->value) disabled @endif>Git pull</button>
                                <button class="btn btn-info detail-project"
                                    data-project-id="{{ $project->id }}">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    @include('pages.project.partials._modal-add-project')
    @include('pages.project.partials._modal-detail-project')
    @include('modal.error')
@endsection

@section('script_js')
    <script>
        $(document).ready(function() {
            $(document).on("click", "#save_new_project", function() {
                $('#form-create-project').submit();
            });

            $(document).on("click", "#save_edit_project", function() {
                $('#form-edit-project').submit();
            });

            $(document).on("click", ".pull-project", function() {
                $('#modal-command').modal('show');
                $('#text-command').text('');
                var project_id = $(this).attr('data-project-id');

                // Start listening for events
                var eventSource = new EventSource(
                `{{ route('project.gitPull') }}?project_id=${project_id}`);

                // Handle messages received
                eventSource.onmessage = function(event) {
                    console.log(event.data); // Logging each line of output

                    // Append each line of output to the command output div
                    $('#text-command').append(`${event.data}\n`);
                };

                eventSource.onerror = function(error) {
                    // Handle any errors that occur
                    console.error('EventSource failed:', error);
                    $('#text-command').text('Link folder sai !');
                    eventSource.close();
                };
            });

            $(document).on("click", ".detail-project", function() {
                deleteValueModal();
                var project_id = $(this).attr('data-project-id');
                $.ajax({
                    type: 'get',
                    data: {
                        project_id: project_id
                    },
                    url: "{{ route('project.detail') }}",
                    success: function(response) {
                        $(".id_project").val(project_id);
                        $("#edit_memo").text(response.project.memo);
                        $("#edit_name_project").val(response.project.name);
                        $("#edit_link_folder").val(response.project.link_folder);
                        // Loop through each radio button
                        $("input[name='edit_status']").each(function() {
                            // Check if the value of the current radio button matches the project status
                            if ($(this).val() == response.project.status) {
                                $(this).prop('checked', true); // Set it as checked
                            }
                        });
                        $('#detailProject').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                    }

                });
            })

            function deleteValueModal()
            {
                $("#edit_memo").text('');
                $("#edit_name_project").val('');
                $("#edit_link_folder").val('');
            }
        });
    </script>
@endsection
