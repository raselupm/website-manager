<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-3xl mb-4">Edit server</div>
                @include('partials.error-message')

                <form action="{{route('servers.edit', $server)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Server name</label>
                        <input value="{{$server->name}}" type="text" name="name" id="name" placeholder="Type domain name without http or https & www" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="ip">Server IP</label>
                        <input value="{{$server->ip}}" type="text" name="ip" id="ip" placeholder="Add server IP address" class="form-control" required>
                    </div>

                    <button x-data="{ addserver: false }" @click="addserver = true" type="submit" class="btn btn-primary">Update server <i x-show="addserver" @click.away="addserver = false" class="fas fa-spin fa-spinner"></i></button>
                    <a href="/servers" class="btn btn-secondary" data-dismiss="modal">Close</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
