@php
    use App\Classes\Enum\ProjectStatusEnum;
@endphp
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
                <div class="form-floating mt-4">
                    <textarea class="form-control" id="memo" style="height: 150px" name="memo"></textarea>
                    <label for="memo">Description</label>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_new_project">Save</button>
            </div>
        </div>
    </div>
</div>
