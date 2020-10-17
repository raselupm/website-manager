<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="font-bold text-3xl mb-4">
                    <div class="row">
                        <div class="col my-auto">Domains</div>
                        <div class="col-auto my-auto">
                            <button data-toggle="modal" data-target="#add-domain" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-3 bg-green-600 hover:bg-green-500 hover:no-underline"><i class="fa fa-plus"></i> Add a domain</button>
                        </div>
                    </div>
                </div>

                @include('partials/error-message')


                <div class="modal fade" id="add-domain" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add a domain</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/add-domain" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Domain name</label>
                                        <input value="{{old('name')}}" type="text" name="name" id="name" placeholder="Type domain name without http or https & www" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Type description">{{old('description')}}</textarea>
                                    </div>

                                    <div class="form-group custom-switch">
                                        <input type="checkbox" checked class="custom-control-input" id="ssl" name="ssl">
                                        <label class="custom-control-label" for="ssl">Have SSL?</label>
                                    </div>

                                    <div class="form-group custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="force_hosting" name="force_hosting">
                                        <label class="custom-control-label" for="force_hosting">Force hosting?</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="cms">CMS</label>
                                        <input value="{{old('cms')}}" type="text" name="cms" id="cms" placeholder="Type CMS name" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="cms_version">CMS version</label>
                                        <input value="{{old('cms_version')}}" type="number" name="cms_version" id="cms_version" placeholder="Type CMS version" class="form-control" step=".01">
                                    </div>

                                    <button x-data="{ adddomain: false }" @click="adddomain = true" type="submit" class="btn btn-primary">Add domain <i x-show="adddomain" @click.away="adddomain = false" class="fas fa-spin fa-spinner"></i></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .to-expire-text {display: none}
                    table span.text-gray-500.font-bold.pl-3.text-sm {
                        font-weight: normal;
                        color: inherit;
                        font-size: inherit;
                    }

                    table span.pl-3 {
                        padding: 0 !important;
                    }
                </style>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="px-4 border py-2 align-middle">Domain</th>
                        <th class="px-4 border py-2 align-middle text-center">Have SSL?</th>
                        <th class="px-4 border py-2 align-middle text-center">Hosted on</th>
                        <th class="px-4 border py-2 align-middle text-center">Domain expires in</th>
                        <th class="px-4 border py-2 align-middle text-center">Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($domains as $domain)
                        <tr>
                            <td class="border px-4 py-2 align-middle"><a target="_blank" class="text-blue-500" href="http://{{$domain->name}}">{{$domain->name}} <i class="fas fa-external-link-alt text-xs"></i></a></td>
                            <td class="border px-4 py-2 align-middle text-center"><i class="{{$domain->ssl == 1 ? 'fas fa-check-circle text-green-700' : 'fas fa-times-circle text-red-700'}}"></i></td>
                            <td class="border px-4 py-2 align-middle text-center">
                                @if(!empty($domain->force_hosting == 1))
                                    PPM VPS <i class="fas fa-check-circle"></i>
                                @else
                                    @if(count(json_decode($domain->dns_data, true)['DNSData']['dnsRecords']) > 0   )
                                        {{ipChecker( json_decode($domain->dns_data, true)['DNSData']['dnsRecords'][0]['address'] )}}
                                    @else
                                        No hosting record
                                    @endif
                                @endif
                            </td>
                            <td class="border px-4 py-2 align-middle text-center">
                                @if(array_key_exists('expiresDate', json_decode($domain->whois_data, true)['WhoisRecord']['registryData']))
                                    {!! expireChecker(json_decode($domain->whois_data, true)['WhoisRecord']['registryData']['expiresDate']) !!}
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


                {{$domains->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
