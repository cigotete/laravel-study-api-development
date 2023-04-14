<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clients
        </h2>
    </x-slot>


    <div id="app">

        <x-container class="py-8">

            {{-- Create clients --}}
            <x-form-section class="mb-12">

                <x-slot name="title">
                    Create new client
                </x-slot>

                <x-slot name="description">
                    Add data in order to create a new client:
                </x-slot>

                <div class="grid grid-cols-6 gap-6">

                    <div class="col-span-6 sm:col-span-4">
                        <x-label>
                            Name
                        </x-label>

                        <x-input type="text" class="w-full mt-1" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label>
                            Redirection URL
                        </x-label>

                        <x-input type="text" class="w-full mt-1" />
                    </div>
                </div>

                <x-slot name="actions">
                    <x-button>
                        Create
                    </x-button>
                </x-slot>
            </x-form-section>

        </x-container>

    </div>

</x-app-layout>