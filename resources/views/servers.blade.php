<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="font-bold text-3xl mb-4">
                    <div class="row">
                        <div class="col my-auto">Servers</div>
                        <div class="col-auto my-auto">
                            <button data-toggle="modal" data-target="#add-server" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-3 bg-green-600 hover:bg-green-500 hover:no-underline"><i class="fa fa-plus"></i> Add a server</button>
                        </div>
                    </div>
                </div>

                @include('partials/error-message')

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
                                <form action="/add-server" method="POST">
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


                <table class="table">
                    <thead>
                    <tr>
                        <th class="px-4 border py-2 align-middle">Name</th>
                        <th class="px-4 border py-2 align-middle text-center">IP address</th>
                        <th class="px-4 border py-2 align-middle text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($servers as $server)
                        <tr>
                            <td class="border px-4 py-2 align-middle">
                                <b class="font-bold">{{$server->name}}</b>
                                <p>{{$server->description}}</p>
                            </td>
                            <td class="border px-4 py-2 align-middle text-center">{{$server->ip}}</td>
                            <td class="border px-4 py-2 align-middle text-center">
                                <a href="/edit-server/{{$server->id}}"><i class="fas fa-edit mr-2"></i></a>
                                <form onSubmit="if(!confirm('Are you sure?')){return false;}" action="/delete-server/{{$server->id}}" class="d-inline" method="POST">
                                    @csrf
                                    <button type="submit"><i class="fas fa-trash text-red-600"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>



            </div>
        </div>
    </div>
</x-app-layout>
