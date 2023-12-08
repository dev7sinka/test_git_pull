@php
    use App\Classes\Enum\ProjectStatusEnum;
@endphp
<div class="modal fade" id="detailProject">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('project.editProject') }}" method="post" class="modal-body" id="form-edit-project">
                @csrf
                <input type="hidden" name="id" class="id_project">
                @foreach ($statusProject as  $status)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_status" id="status{{ $status['name'] }}"
                            value="{{ $status['value'] }}">
                        <label class="form-check-label" for="status{{ $status['name'] }}">{{ $status['name'] }}</label>
                    </div>
                @endforeach
                <div class="form-floating mt-4">
                    <input class="form-control" id="edit_name_project" name="edit_name_project">
                    <label for="name_project">Name project</label>
                </div>
                <div class="form-floating mt-4">
                    <input class="form-control" id="edit_link_folder" name="edit_link_folder">
                    <label for="link_folder">Link folder</label>
                </div>
                <div class="form-floating mt-4">
                    <textarea class="form-control" id="edit_memo" style="height: 150px" name="edit_memo"></textarea>
                    <label for="memo">Description</label>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_edit_project">Save</button>
            </div>
        </div>
    </div>
</div>
