<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-3xl mb-4">Edit domain</div>

                <livewire:domain-edit :domainID="$domainID"/>
            </div>
        </div>
    </div>
</x-app-layout>
