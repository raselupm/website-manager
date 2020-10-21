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

                @include('partials.error-message')

                @include('servers.create-modal')

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
                                <a href="{{route('servers.edit', $server)}}"><i class="fas fa-edit mr-2"></i></a>
                                <form onSubmit="if(!confirm('Are you sure?')){return false;}" action="{{route('servers.delete', $server)}}" class="d-inline" method="POST">
                                    @csrf
                                    @method('DELETE')
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
