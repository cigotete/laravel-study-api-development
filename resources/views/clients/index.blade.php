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

            {{-- Modal Edit --}}
        <x-dialog-modal modal="editForm.open">
            <x-slot name="title">
                Edit client
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">

                    <div v-if="editForm.errors.length > 0"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <strong class="font-bold">Whoops!</strong>
                        <span>¡Something wrong!</span>

                        <ul>
                            <li v-for="error in editForm.errors">
                                @{{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="">

                        <x-label>
                            Name
                        </x-label>

                        <x-input v-model="editForm.name" type="text" class="w-full mt-1" />
                    </div>

                    <div class="">
                        <x-label>
                            Redirection URL
                        </x-label>

                        <x-input v-model="editForm.redirect" type="text" class="w-full mt-1" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button type="button"
                    v-on:click="update()"
                    v-bind:disabled="editForm.disabled"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Update
                </button>



                <button v-on:click="editForm.open = false" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </x-slot>

        </x-dialog-modal>

        {{-- Modal Show --}}
        <x-dialog-modal modal="showClient.open">
            <x-slot name="title">
                Show credentials
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2">

                    <p>
                        <span class="font-semibold">CLIENT: </span>
                        <span v-text="showClient.name"></span>
                    </p>

                    <p>
                        <span class="font-semibold">CLIENT_ID: </span>
                        <span v-text="showClient.id"></span>
                    </p>

                    <p>
                        <span class="font-semibold">CLIENT_SECRET: </span>
                        <span v-text="showClient.secret"></span>
                    </p>

                </div>
            </x-slot>

            <x-slot name="footer">
                <button v-on:click="showClient.open = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Cancelar
                </button>
            </x-slot>

        </x-dialog-modal>

        </x-container>

    </div>

    @push('js')

        <script>
            const { createApp } = Vue
            createApp ({
                data() {
                    return {
                        clients: [],
                        showClient: {
                            open: false,
                            name: null,
                            id: null,
                            secret: null
                        },
                        createForm: {
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null,
                        },
                        editForm: {
                            open: false,
                            errors: [],
                            disabled: false,
                            errors: [],
                            id: null,
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

                    show(client){
                        this.showClient.open = true;
                        this.showClient.name = client.name;
                        this.showClient.id = client.id;
                        this.showClient.secret = client.secret;
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

                                this.show(response.data);
                                this.getClients();
                                this.createForm.disabled = false;

                            }).catch(error => {
                                this.createForm.errors = Object.values(error.response.data.errors).flat();
                                this.createForm.disabled = false;
                            })
                    },

                    edit(client){
                        this.editForm.open = true;
                        this.editForm.errors = [];

                        this.editForm.id = client.id;
                        this.editForm.name = client.name;
                        this.editForm.redirect = client.redirect;
                    },

                    update(){
                        this.editForm.disabled = true;

                        axios.put('/oauth/clients/' + this.editForm.id, this.editForm)
                            .then(response => {
                                this.editForm.open = false;
                                this.editForm.disabled = false;
                                this.editForm.name = null;
                                this.editForm.redirect = null;
                                this.editForm.errors = [];

                                Swal.fire(
                                    'Updated!',
                                    'Client updated successfully.',
                                    'success'
                                );

                                this.getClients();

                            }).catch(error => {

                                this.editForm.errors = Object.values(error.response.data.errors).flat();

                                this.editForm.disabled = false;

                            })
                    },

                    destroy(client) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                axios.delete('/oauth/clients/' + client.id)
                                    .then(response => {
                                        this.getClients();
                                    });

                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                        })
                    }
                }
            }).mount('#app');
        </script>

    @endpush

</x-app-layout>