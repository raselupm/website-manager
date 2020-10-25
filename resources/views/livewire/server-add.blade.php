<form wire:submit.prevent="submitForm" method="POST" >
    @csrf
    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
            Sercer name <span class="text-bold text-red-600">*</span>
        </label>
        <input wire:model.lazy="name" id="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Type server name">

        @error('name')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="ip">
            Server IP <span class="text-bold text-red-600">*</span>
        </label>

        <input wire:model.lazy="ip" id="ip" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Type server IP address">

        @error('ip')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>



    <div class="border-t border-gray-100 pt-3 mt-5">
        <x-jet-button class="modal-button" type="submit">
            <i wire:loading wire:target="submitForm" class="fa fa-spin fa-spinner mr-3"></i>
            Add server
        </x-jet-button>
    </div>
</form>
