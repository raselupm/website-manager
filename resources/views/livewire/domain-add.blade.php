<form wire:submit.prevent="submitForm" method="POST" >
    @csrf
    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
            Domain name <span class="text-bold text-red-600">*</span>
        </label>
        <input wire:model.lazy="name" id="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Type domain name without http or https & www">

        @error('name')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="description">
            Description
        </label>

        <textarea wire:model.lazy="description" id="description" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" cols="30" rows="2" placeholder="Type description"></textarea>

        @error('description')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>



    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="ssl">
            Have SSL? <span class="text-bold text-red-600">*</span>
        </label>

        <input class="cursor-pointer" wire:model.lazy="ssl" type="radio" name="ssl" id="ssl[1]" value="1">
        <label class="cursor-pointer mr-2" for="ssl[1]">Yes</label>

        <input class="cursor-pointer" wire:model.lazy="ssl" type="radio" name="ssl" id="ssl[2]" value="0">
        <label class="cursor-pointer" for="ssl[2]">No</label>

        @error('ssl')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cms">
            CMS
        </label>
        <input wire:model.lazy="cms" id="cms" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Type CMS name">

        @error('cms')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cms_version">
            CMS version
        </label>
        <input wire:model.lazy="cms_version" id="cms_version" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Type CMS version">

        @error('cms_version')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="force_hosting">
            Force hosting? <span class="text-bold text-red-600">*</span>
        </label>

        <input class="cursor-pointer" wire:model.lazy="force_hosting" type="radio" name="force_hosting" id="force_hosting[1]" value="1">
        <label class="cursor-pointer mr-2" for="force_hosting[1]">Yes</label>

        <input class="cursor-pointer" wire:model.lazy="force_hosting" type="radio" name="force_hosting" id="force_hosting[2]" value="0">
        <label class="cursor-pointer" for="force_hosting[2]">No</label>

        @error('force_hosting')
        <span class="text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="border-t border-gray-100 pt-3 mt-5">
        <x-jet-button class="modal-button" type="submit">
            <i wire:loading wire:target="submitForm" class="fa fa-spin fa-spinner mr-3"></i>
            Add domain
        </x-jet-button>
    </div>
</form>
