<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="row">
                    <div class="col my-auto">
                        <div class="font-bold text-3xl mb-4">{{$domain->name}}</div>
                    </div>
                    <div class="col-auto my-auto">
                        <a href="/edit-domain/{{$domain->id}}"><i class="fas fa-edit mr-2"></i></a>
                        <form onSubmit="if(!confirm('Are you sure?')){return false;}" action="/delete-domain/{{$domain->id}}" class="d-inline" method="POST">
                            @csrf
                            <button type="submit"><i class="fas fa-trash text-red-600"></i></button>
                        </form>
                    </div>
                </div>

                @include('partials/error-message')


                <div class="row">
                    @if(!empty($domain->cms))
                    <div class="col">
                        <div class="border p-4">
                            <h4 class="font-bold text-xl mb-2">{{$domain->cms}}</h4>
                            Version: {{$domain->cms_version}}
                        </div>
                    </div>
                    @endif

                    <div class="col">
                        <div class="border p-4">
                            <h4 class="font-bold text-xl mb-2">Hosted on</h4>
                            @if(!empty($domain->force_hosting == 1))
                                PPM VPS <i class="fas fa-check-circle"></i>
                            @else
                            {{$domain->ipChecker( json_decode($domain->dns_data, true)['DNSData']['dnsRecords'][0]['address'] )}}
                            @endif
                        </div>
                    </div>

                    @if(count(json_decode($domain->dns_data, true)['DNSData']['dnsRecords']) > 1)
                    <div class="col">
                        <div class="border p-4">
                            <h4 class="font-bold text-xl mb-2">Email</h4>
                            {{end(json_decode($domain->dns_data, true)['DNSData']['dnsRecords'])['target']}}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <form action="/refresh" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{$domain->name}}">
                            <button x-data="{ open: false }" type="submit" @click="open = true" class="btn btn-primary">Refresh data <i x-show="open" @click.away="open = false" class="fas fa-spin fa-spinner"></i></button>
                        </form>
                    </div>
                    <div class="col-auto">Last update: {{$domain->updated_at->diffForHumans()}}</div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
