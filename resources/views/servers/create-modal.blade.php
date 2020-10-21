<div class="modal fade" id="add-server" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a server</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('servers.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Server name</label>
                        <input value="{{old('name')}}" type="text" name="name" id="name" placeholder="Type server name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="ip">Server IP</label>
                        <input value="{{old('ip')}}" type="text" name="ip" id="ip" placeholder="Add server IP address" class="form-control" required>
                    </div>

                    <button x-data="{ addserver: false }" @click="addserver = true" type="submit" class="btn btn-primary">Add server <i x-show="addserver" @click.away="addserver = false" class="fas fa-spin fa-spinner"></i></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
