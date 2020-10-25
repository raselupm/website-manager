<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-jet-button class="modal-button-{{$random}}" type="button">
        <i class="{{$modalIcon}}"></i> {{$modalBtnText}}
    </x-jet-button>


    <div class="modal modal-{{$random}} z-10 opacity-0 pointer-events-none fixed overflow-y-scroll w-full h-full top-0 left-0 flex justify-center">
        <div class="modal-overlay{{$random}} fixed w-full h-full bg-black opacity-25 top-0 left-0 cursor-pointer"></div>
        <div class="absolute w-1/2 bg-white rounded-sm shadow-lg items-center justify-center text-base mt-10 mb-10">
            <i class="fas fa-times absolute right-0 top-0 mr-5 mt-5 cursor-pointer modal-close-{{$random}}"></i>
            <div class="w-full p-5">
                @if(!empty($modalTitle))
                    <h3 class="font-bold text-xl mb-4">{{$modalTitle}}</h3>
                @endif

                @if($modalContent == 'domain-add')
                    <livewire:domain-add />
                @elseif($modalContent == 'server-add')
                    <livewire:server-add />
                @else
                    {{$modalContent}}
                @endif
            </div>
        </div>
    </div>

    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
    </style>

    <script>
        const button{{$random}} = document.querySelector('.modal-button-{{$random}}')
        const closeButton{{$random}} = document.querySelector('.modal-close-{{$random}}')
        button{{$random}}.addEventListener('click', toggleModal{{$random}})
        closeButton{{$random}}.addEventListener('click', toggleModal{{$random}})

        const overlay{{$random}} = document.querySelector('.modal-overlay{{$random}}')
        overlay{{$random}}.addEventListener('click', toggleModal{{$random}})


        function toggleModal{{$random}} () {
            const modal{{$random}} = document.querySelector('.modal-{{$random}}')
            modal{{$random}}.classList.toggle('opacity-0')
            modal{{$random}}.classList.toggle('pointer-events-none')
        }
    </script>
</div>
