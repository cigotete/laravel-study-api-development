<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clients
        </h2>
    </x-slot>


    <div id="app">

        <x-container class="py-8">

        {{-- Show clients --}}
            <x-form-section v-if="clients.length > 0">

                <x-slot name="title">
                    Client list
                </x-slot>

                <x-slot name="description">
                    Clients you added:
                </x-slot>

                <div>

                    <table class="text-gray-600">
                        <thead class="border-b border-gray-300">
                            <tr class="text-left">
                                <th class="py-2 w-full">Name</th>
                                <th class="py-2">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-300">
                            <tr v-for="client in clients">
                                <td class="py-2">
                                    @{{ client . name }}
                                </td>

                                <td class="flex divide-x divide-gray-300 py-2">
                                    <a v-on:click="show(client)" class="pr-2 hover:text-green-600 font-semibold cursor-pointer">
                                        Show
                                    </a>

                                    <a v-on:click="edit(client)" class="px-2 hover:text-blue-600 font-semibold cursor-pointer">
                                        Edit
                                    </a>

                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer"
                                        v-on:click="destroy(client)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>


            </x-form-section>

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
                        clients: [],
                        createForm: {
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null,
                        }
                    }
                },
                mounted() {
                    this.getClients();
                },
                methods: {
                    getClients() {
                        axios.get('/oauth/clients')
                            .then(response => {
                                this.clients = response.data
                            });
                    },

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

                                this.getClients();
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