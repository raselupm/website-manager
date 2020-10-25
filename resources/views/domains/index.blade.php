<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="font-bold text-3xl mb-4">
                    <div class="flex items-center">
                        <div class="flex-1">Domains</div>
                        <div class="flex">

                            <livewire:modal modalIcon="fas fa-plus mr-2" modalBtnText="Add a domain" modalTitle="Add a domain" modalContent="domain-add"/>
                        </div>
                    </div>
                </div>

                <livewire:domain-index/>
            </div>
        </div>
    </div>
</x-app-layout>
