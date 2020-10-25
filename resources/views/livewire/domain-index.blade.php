<div>
    <table class="table-auto w-full">
        <thead>
        <tr>
            <th class="px-4 border py-2 align-middle">Domain</th>
            <th class="px-4 border py-2 align-middle text-center">SSL</th>
            <th class="px-4 border py-2 align-middle text-center">Status</th>
            <th class="px-4 border py-2 align-middle text-center">Hosted on</th>
            <th class="px-4 border py-2 align-middle text-center">Domain expires in</th>
            <th class="px-4 border py-2 align-middle text-center">Details</th>
        </tr>
        </thead>
        <tbody>
        @foreach($domains as $domain)
            <tr>
                <td class="border px-4 py-2 align-middle">
                    <a target="_blank" class="text-blue-500" href="http://{{$domain->name}}">{{$domain->name}} <i class="fas fa-external-link-alt text-xs"></i></a>
                </td>
                <td class="border px-4 py-2 align-middle text-center"><i class="{{$domain->ssl == 1 ? 'fas fa-check-circle text-green-700' : 'fas fa-times-circle text-red-700'}}"></i></td>

                <td class="border px-4 py-2 align-middle text-center">
                    @if(count($domain->events()->latest()->get()) > 0)
                        @if($domain->events()->latest()->get()->first()->type == 1)
                            <span class="text-green-700">Site is up <i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-red-700">Site is down <i class="fas fa-times-circle"></i></span>
                        @endif

                    @else
                        <span class="text-yellow-700">Unknown <i class="fas fa-exclamation-triangle"></i></span>

                    @endif
                </td>
                <td class="border px-4 py-2 align-middle text-center">
                    @if(!empty($domain->force_hosting == 1))
                        PPM VPS <i class="fas fa-check-circle"></i>
                    @else
                        @if(array_key_exists('DNSData', json_decode($domain->dns_data, true)))
                            @if(count(json_decode($domain->dns_data, true)['DNSData']['dnsRecords']) > 0   )
                                {{ipChecker( json_decode($domain->dns_data, true)['DNSData']['dnsRecords'][0]['address'] )}}
                            @else
                                No hosting record
                            @endif
                        @else
                            No hosting record
                        @endif

                    @endif
                </td>
                <td class="border px-4 py-2 align-middle text-center">
                    @if(array_key_exists('WhoisRecord', json_decode($domain->whois_data, true)))
                        @if(array_key_exists('expiresDate', json_decode($domain->whois_data, true)['WhoisRecord']['registryData']))
                            {!! expireChecker(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['expiresDate']) !!}
                        @else
                            No record
                        @endif
                    @else
                        No record
                    @endif

                </td>
                <td class="border px-4 py-2 align-middle text-center">
                    {{--                                <a href="/edit-domain/{{$domain->id}}" class="btn btn-secondary btn-sm mr-4">Edit <i class="fa fa-edit ml-1"></i></a>--}}
                    <a href="/{{$domain->name}}" class="btn btn-primary btn-sm">Details <i class="fas fa-angle-double-right ml-1"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-5">{{$domains->links()}}</div>
</div>
