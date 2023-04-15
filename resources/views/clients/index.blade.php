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

                      <div v-if="createForm.errors.length > 0"
                          class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                          <strong class="font-bold">Whoops!</strong>
                          <span>¡Something wrong!</span>

                          <ul>
                              <li v-for="error in createForm.errors">
                                  @{{ error }}
                              </li>
                          </ul>
                      </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label>
                            Name
                        </x-label>

                        <x-input v-model="createForm.name" type="text" class="w-full mt-1" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label>
                            Redirection URL
                        </x-label>

                        <x-input v-model="createForm.redirect" type="text" class="w-full mt-1" />
                    </div>
                </div>

                <x-slot name="actions">
                    <x-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        Create
                    </x-button>
                </x-slot>
            </x-form-section>

        </x-container>

    </div>

    @push('js')

        <script>
            const { createApp } = Vue
            createApp ({
                data() {
                    return {
                        createForm: {
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null,
                        }
                    }
                },

                methods: {
                    store() {

                        this.createForm.disabled = true;

                        axios.post('/oauth/clients', this.createForm)
                            .then(response => {
                                this.createForm.name = null;
                                this.createForm.redirect = null;
                                this.createForm.errors = [];

                                Swal.fire(
                                    'Created!',
                                    'Client created successfully.',
                                    'success'
                                );

                                this.createForm.disabled = false;

                            }).catch(error => {
                                this.createForm.errors = Object.values(error.response.data.errors).flat();
                                this.createForm.disabled = false;
                            })
                    }
                }
            }).mount('#app');
        </script>

    @endpush

</x-app-layout>