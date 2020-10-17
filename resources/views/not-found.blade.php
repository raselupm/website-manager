<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(!empty($result))

                    <div class="row mb-4">
                        <div class="col my-auto">
                            <div class="text-3xl">
                                DNS record for <b class="font-bold">{{$keyword}}</b>

                                @if($up == true)
                                    <span class="badge badge-success text-xs relative bottom-1 ml-3">Site is up <i class="fa fa-check"></i></span>
                                @else
                                    <span class="badge badge-danger text-xs relative bottom-1 ml-3">Site is down <i class="fas fa-exclamation-triangle"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        @if(count(json_decode($result, true)['DNSData']['dnsRecords']) > 0   )
                        <div class="col">
                            <div class="border p-4">
                                <h4 class="font-bold text-xl mb-2">Hosted on</h4>
                                {{ipChecker( json_decode($result, true)['DNSData']['dnsRecords'][0]['address'] )}}
                            </div>
                        </div>
                        @endif

                        @if(count(json_decode($result, true)['DNSData']['dnsRecords']) > 1)
                           @if(end(json_decode($result, true)['DNSData']['dnsRecords'])['dnsType'] == 'MX')
                            <div class="col">
                                <div class="border p-4">
                                    <h4 class="font-bold text-xl mb-2">Email hosting provider</h4>
                                    {{mxProviderChecker(end(json_decode($result, true)['DNSData']['dnsRecords'])['target'])}}
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>


                    @if(array_key_exists('dataError', json_decode($whois_result, true)['WhoisRecord']))
                    @else
                        <div class="row mt-4">
                            <div class="col">
                                <h3 class="font-bold text-xl  mb-3">Domain register information</h3>
                                <table class="table-auto">
                                    <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">Registered date</td>
                                        <td class="border px-4 py-2">
                                            {{date('F j, Y', strtotime(json_decode($whois_result, true)['WhoisRecord']['registryData']['createdDate']))}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Update date</td>
                                        <td class="border px-4 py-2">
                                            {{date('F j, Y', strtotime(json_decode($whois_result, true)['WhoisRecord']['registryData']['updatedDate']))}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Expire date</td>
                                        <td class="border px-4 py-2">
                                            {{date('F j, Y', strtotime(json_decode($whois_result, true)['WhoisRecord']['registryData']['expiresDate']))}}

                                            {!! expireChecker(json_decode($whois_result, true)['WhoisRecord']['registryData']['expiresDate']) !!}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Name servers</td>
                                        <td class="border px-4 py-2">
                                            @foreach(json_decode($whois_result, true)['WhoisRecord']['registryData']['nameServers']['hostNames'] as $ns)
                                                <p>{{$ns}}</p>
                                            @endforeach
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col">
                                <h3 class="font-bold text-xl  mb-3">Domain contact information</h3>
                                <table class="table-auto">
                                    <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">Contact</td>
                                        <td class="border px-4 py-2">
                                            @if(array_key_exists('registrant', json_decode($whois_result, true)['WhoisRecord']))
                                                @if(array_key_exists('name', json_decode($whois_result, true)['WhoisRecord']['registrant']))
                                                {{json_decode($whois_result, true)['WhoisRecord']['registrant']['name']}}
                                                @endif

                                                @if(array_key_exists('organization', json_decode($whois_result, true)['WhoisRecord']['registrant']))
                                                <br/>{{json_decode($whois_result, true)['WhoisRecord']['registrant']['organization']}}
                                                @endif
                                            @else
                                                {{json_decode($whois_result, true)['WhoisRecord']['registryData']['registrant']['organization']}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border px-4 py-2">Email address</td>
                                        <td class="border px-4 py-2">
                                            {{json_decode($whois_result, true)['WhoisRecord']['contactEmail']}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border px-4 py-2">Address</td>
                                        <td class="border px-4 py-2">
                                            @if(array_key_exists('registrant', json_decode($whois_result, true)['WhoisRecord']))
                                                {{json_decode($whois_result, true)['WhoisRecord']['registrant']['state']}}, {{json_decode($whois_result, true)['WhoisRecord']['registrant']['country']}}
                                            @else
                                                {{json_decode($whois_result, true)['WhoisRecord']['registryData']['registrant']['state']}}, {{json_decode($whois_result, true)['WhoisRecord']['registryData']['registrant']['country']}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border px-4 py-2">Registrar name</td>
                                        <td class="border px-4 py-2">
                                            {{json_decode($whois_result, true)['WhoisRecord']['registrarName']}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-3xl mb-2">Sorry, <b class="font-bold">{{$keyword}}</b> doesn't match our record.</div>
                    <p class="mb-3">But yes, you can always check its record.</p>

                    <form action="/check" method="POST">
                        @csrf
                        <input type="hidden" name="name" value="{{$keyword}}">


                        <button x-data="{ open: false }" type="submit" @click="open = true" class="btn btn-primary">Check {{$keyword}}'s record <i x-show="open" @click.away="open = false" class="fas fa-spin fa-spinner ml-2"></i></button>
                    </form>
                @endif



                @include('partials/error-message')




            </div>
        </div>
    </div>
</x-app-layout>
