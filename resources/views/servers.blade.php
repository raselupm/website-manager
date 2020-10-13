<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="font-bold text-3xl mb-4">Servers</div>
                @include('partials/error-message')


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
