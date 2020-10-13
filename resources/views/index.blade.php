<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="font-bold text-3xl mb-4">
                    <div class="row">
                        <div class="col my-auto">Domains</div>
                        <div class="col-auto my-auto">
                            <a href="/servers" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-3 bg-green-600 hover:bg-green-500 hover:no-underline">Servers</a>
                        </div>
                    </div>

                </div>
                @include('partials/error-message')


                <table class="table">
                    <thead>
                    <tr>
                        <th class="px-4 border py-2 align-middle">Domain</th>
                        <th class="px-4 border py-2 align-middle text-center">Have SSL?</th>
                        <th class="px-4 border py-2 align-middle text-center">Hosted on</th>
                        <th class="px-4 border py-2 align-middle text-center">Details</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($domains as $domain)
                        <tr>
                            <td class="border px-4 py-2 align-middle"><a target="_blank" class="text-blue-500" href="http://{{$domain->name}}">{{$domain->name}}</a></td>
                            <td class="border px-4 py-2 align-middle text-center"><i class="{{$domain->ssl == 1 ? 'fas fa-check-circle text-green-700' : 'fas fa-times-circle text-red-700'}}"></i></td>
                            <td class="border px-4 py-2 align-middle text-center">
                                @if(!empty($domain->force_hosting == 1))
                                    PPM VPS <i class="fas fa-check-circle"></i>
                                @else
                                    {{$domain->ipChecker( json_decode($domain->dns_data, true)['DNSData']['dnsRecords'][0]['address'] )}}
                                @endif
                            </td>
                            <td class="border px-4 py-2 align-middle text-center">
                                <a href="/{{$domain->name}}" class="btn btn-primary btn-sm">Details <i class="fas fa-angle-double-right ml-1"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
