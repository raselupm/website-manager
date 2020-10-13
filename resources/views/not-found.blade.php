<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(!empty($result))



                    <div class="text-3xl mb-2">DNS record for <b class="font-bold">{{$keyword}}</b></div>

                    <div class="row">

                        <div class="col">
                            <div class="border p-4">
                                <h4 class="font-bold text-xl mb-2">Hosted on</h4>
                                {{json_decode($result, true)['DNSData']['dnsRecords'][0]['address']}}
                            </div>
                        </div>

                        <div class="col">
                            <div class="border p-4">
                                <h4 class="font-bold text-xl mb-2">Email</h4>
                                {{end(json_decode($result, true)['DNSData']['dnsRecords'])['target']}}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-3xl mb-2">Sorry, <b class="font-bold">{{$keyword}}</b> doesn't match our record.</div>
                    <p class="mb-3">But yes, you can always check its record.</p>

                    <form action="/check" method="POST">
                        @csrf
                        <input type="hidden" name="name" value="{{$keyword}}">
                        <button type="submit" class="btn btn-primary">Check {{$keyword}}'s record</button>
                    </form>
                @endif



                @include('partials/error-message')




            </div>
        </div>
    </div>
</x-app-layout>
