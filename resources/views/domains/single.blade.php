<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex mb-4">
                    <div class="flex-1">
                        <div class="font-bold text-3xl">
                            {{$domain->name}}



                            @if(!empty($lastEvent))
                                @if($lastEvent->type == 1)
                                    <span class="bg-green-500 text-white rounded px-2 py-1 text-xs relative bottom-1 ml-3">Site is up <i class="fa fa-check"></i></span>
                                @else
                                    <span class="bg-red-500 text-white rounded px-2 py-1 text-xs relative bottom-1 ml-3">Site is down <i class="fas fa-exclamation-triangle"></i></span>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="flex">
                        <a href="/edit-domain/{{$domain->id}}"><i class="fas fa-edit mr-2"></i></a>
                        <form onSubmit="if(!confirm('Are you sure?')){return false;}" action="/delete-domain/{{$domain->id}}" class="d-inline" method="POST">
                            @csrf
                            <button type="submit"><i class="fas fa-trash text-red-600"></i></button>
                        </form>
                    </div>
                </div>



                <div class="flex -mx-3">
                    @if(!empty($domain->cms))
                        <div class="flex-1 px-3">
                            <div class="border p-4">
                                <h4 class="font-bold text-xl mb-2">{{$domain->cms}}</h4>
                                Version: {{$domain->cms_version}}
                            </div>
                        </div>
                    @endif

                    @if(array_key_exists('DNSData', json_decode($domain->dns_data, true)))
                        @if(count(json_decode($domain->dns_data, true)['DNSData']['dnsRecords']) > 0   )
                            <div class="flex-1 px-3">
                                <div class="border p-4">
                                    <h4 class="font-bold text-xl mb-2">Hosted on</h4>
                                    @if(!empty($domain->force_hosting == 1))
                                        PPM VPS <i class="fas fa-check-circle"></i>
                                    @else
                                        {{ipChecker( json_decode($domain->dns_data, true)['DNSData']['dnsRecords'][0]['address'] )}}
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(count(json_decode($domain->dns_data, true)['DNSData']['dnsRecords']) > 1)
                            @if(end(json_decode($domain->dns_data, true)['DNSData']['dnsRecords'])['dnsType'] == 'MX')
                                <div class="flex-1 px-3">
                                    <div class="border p-4">
                                        <h4 class="font-bold text-xl mb-2">Email hosting provider</h4>
                                        {{mxProviderChecker(end(json_decode($domain->dns_data, true)['DNSData']['dnsRecords'])['target'])}}
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>


                @if(array_key_exists('WhoisRecord', json_decode($domain->whois_data, true)))
                    @if(array_key_exists('dataError', json_decode($domain->whois_data, true)['WhoisRecord']))
                    @else
                        <div class="flex mt-4 -mx-3">
                            <div class="flex-1 px-3">
                                <h3 class="font-bold text-xl  mb-3">Domain register information</h3>

                                <table class="table-auto">
                                    <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">Registered date</td>
                                        <td class="border px-4 py-2">{{date('F j, Y', strtotime(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['createdDate']))}}</td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Update date</td>
                                        <td class="border px-4 py-2">{{date('F j, Y', strtotime(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['updatedDate']))}}</td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Expire date</td>
                                        <td class="border px-4 py-2">{{date('F j, Y', strtotime(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['expiresDate']))}} {!! expireChecker(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['expiresDate']) !!}</td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Name servers</td>
                                        <td class="border px-4 py-2">
                                            @foreach(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['nameServers']['hostNames'] as $ns)
                                                <p>{{$ns}}</p>
                                            @endforeach
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="flex-1 px-3">
                                <h3 class="font-bold text-xl  mb-3">Domain contact information</h3>
                                <table class="table-auto">
                                    <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">Contact</td>
                                        <td class="border px-4 py-2">
                                            @if(array_key_exists('registrant', json_decode($domain->whois_data, true)['WhoisRecord']))

                                                @if(array_key_exists('name', json_decode($domain->whois_data, true)['WhoisRecord']['registrant']))
                                                    {{json_decode($domain->whois_data, true)['WhoisRecord']['registrant']['name']}},
                                                @endif

                                                @if(array_key_exists('organization', json_decode($domain->whois_data, true)['WhoisRecord']['registrant']))
                                                    {{json_decode($domain->whois_data, true)['WhoisRecord']['registrant']['organization']}}
                                                @endif
                                            @else
                                                @if(array_key_exists('organization', json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['registrant']))
                                                {{json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['registrant']['organization']}}
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border px-4 py-2">Email address</td>
                                        <td class="border px-4 py-2">
                                            {{json_decode($domain->whois_data, true)['WhoisRecord']['contactEmail']}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Address</td>
                                        <td class="border px-4 py-2">
                                            @if(array_key_exists('registrant', json_decode($domain->whois_data, true)['WhoisRecord']))
                                                {{json_decode($domain->whois_data, true)['WhoisRecord']['registrant']['state']}}, {{json_decode($domain->whois_data, true)['WhoisRecord']['registrant']['country']}}
                                            @else
                                                {{json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['registrant']['state']}}, {{json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['registrant']['country']}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border px-4 py-2">Registrar name</td>
                                        <td class="border px-4 py-2">
                                            {{json_decode($domain->whois_data, true)['WhoisRecord']['registrarName']}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endif



                <div class="flex mt-4">
                    <div class="flex-1">
                        <form action="/refresh" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{$domain->name}}">
                            <button x-data="{ open: false }" type="submit" @click="open = true" class="bg-blue-600 text-white rounded py-1 px-4 border-none">Refresh data <i x-show="open" @click.away="open = false" class="fas fa-spin fa-spinner"></i></button>
                        </form>
                    </div>
                    <div class="flex">Last update: {{$domain->updated_at->diffForHumans()}}</div>
                </div>


            </div>


            @if(!empty($lastEvent))
            <h2 class="mt-10 font-bold text-2xl">Uptime logs</h2>

            <div class="bg-white shadow-lg rounded p-4 mt-4">
                <table class="table-auto text-center w-full m-0">
                    <thead>
                    <tr>
                        <th class="border px-4 py-2">Event</th>
                        <th class="border px-4 py-2">Date time</th>
                        <th class="border px-4 py-2">Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($domain->latestEvents as $event)
                    <tr>
                        <td class="border px-4 py-2">{!! uptimeType($event->type) !!}</td>
                        <td class="border px-4 py-2">{{date('F j, Y - g:i a', strtotime($event->created_at))}}</td>
                        <td class="border px-4 py-2">
                            @if(empty($event->end_time))




                                <div class="current-timer"></div>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.9.0/timer.jquery.min.js" integrity="sha512-DeNeekCILcrzL1FtTl+zjBD6z2nGucwdZJeZOXtoS9hfL3azWLzqfDgll61D6jO/EhM9gx4PokARMUfgrwiQfw==" crossorigin="anonymous" defer></script>
                                <script>
                                    $(document).ready(function () {
                                        $('.current-timer').timer({
                                            seconds: {{strtotime(now()) - strtotime($event->created_at)}},
                                            format: '{{dynamicJSFormat($event->created_at)}}'
                                        });
                                    });
                                </script>
                            @else
                            @if($event->created_at->diff($event->end_time)->format('%h') > 0)
                                {{$event->created_at->diff($event->end_time)->format('%h')}} {{$event->created_at->diff($event->end_time)->format('%h') > 1 ? 'hours' : 'hour'}}
                            @endif

                            @if($event->created_at->diff($event->end_time)->format('%i') > 0)
                                {{$event->created_at->diff($event->end_time)->format('%i')}} {{$event->created_at->diff($event->end_time)->format('%i') > 1 ? 'minutes' : 'minute'}}
                            @endif

                            {{$event->created_at->diff($event->end_time)->format('%s')}} {{$event->created_at->diff($event->end_time)->format('%s') > 1 ? 'seconds' : 'second'}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
