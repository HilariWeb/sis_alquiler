<div>
    {{-- In work, do what you enjoy. --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('inquilinos') }}">Listado de Inquilinos</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <br><br>
    <hr>
    <br>

    <flux:button variant="primary" wire:click="openCreateModal" color="blue">Crear nuevo inquilino</flux:button>

    <br><br>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-black border border-b divide-y divide-gray-200" style="width: 100%">
            <thead class="border-b bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th class="py-3 px-4" style="background-color: #f0f0f0">Nro</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Nombres</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Email</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Teléfono</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Fecha de nacimiento</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Documento de identidad</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Acciones</th>
            </thead>
            <tbody>
                @foreach ($inquilinos as $inquilino)
                    <tr style="border: 1px solid f0f0f0;">
                        <td class="py-3 px-4" style="text-align: center">{{ $inquilino->id }}</td>
                        <td>{{ $inquilino->nombres }}</td>
                        <td>{{ $inquilino->email }}</td>
                        <td>{{ $inquilino->telefono }}</td>
                        <td style="text-align: center">{{ $inquilino->fecha_nacimiento }}</td>
                        <td style="text-align: center">{{ $inquilino->documento_identidad }}</td>
                        <td>
                          <flux:button variant="primary" color="teal" wire:click="show({{ $inquilino->id }})">Ver
                            </flux:button>
                            <flux:button variant="primary" color="green" wire:click="edit({{ $inquilino->id }})">Editar
                            </flux:button>
                            <flux:button variant="primary" color="red" wire:click="confirmDelete({{ $inquilino->id }})">Borrar
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $inquilinos->links() }}
        </div>

    </div>



    {{-- Modal para la vista create inquilinos --}}
    <flux:modal name="create-inquilino" class="md:w-96" style="width: 600px" wire:model="createModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear nuevo</flux:heading>
                <flux:text class="mt-2">Llene todos los campos requeridos</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <flux:label for="nombres">Nombres <b>(*)</b></flux:label>
                    <flux:input type="text" id="nombres" wire:model="nombres" required />
                    @error('nombres')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="email">Email <b>(*)</b></flux:label>
                    <flux:input type="email" id="email" wire:model="email" required />
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="telefono">Teléfono <b>(*)</b></flux:label>
                    <flux:input type="text" id="telefono" wire:model="telefono" required />
                    @error('telefono')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="fecha_nacimiento">Fecha de nacimiento <b>(*)</b></flux:label>
                    <flux:input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" required />
                    @error('fecha_nacimiento')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="documento_identidad">Documento de identidad <b>(*)</b></flux:label>
                    <flux:input type="text" id="documento_identidad" wire:model="documento_identidad" required />
                    @error('documento_identidad')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
               

                <br><br>

                <div class="flex justify-end">
                    <flux:modal.close name="crear-inquilino" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="primary">Crear Inquilino</flux:button>
                </div>

            </form>

        </div>
    </flux:modal>



    {{-- Modal para la vista show inquilinos --}}
    <flux:modal name="show-inquilino" class="md:w-96" style="width: 600px" wire:model="showModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Datos del inquilino</flux:heading>
                <flux:text class="mt-2">Datos registrados</flux:text>
            </div>

           
                @if ($inquilinoSeleccionado)
                    <div>
                    <flux:label for="nombres">Nombres </flux:label>
                    <p>{{ $inquilinoSeleccionado->nombres }}</p>
                </div>

                <div>
                    <flux:label for="email">Email</flux:label>
                    <p>{{ $inquilinoSeleccionado->email }}</p>
                </div>

                <div>
                    <flux:label for="telefono">Teléfono</flux:label>
                    <p>{{ $inquilinoSeleccionado->telefono }}</p>
                </div>

                <div>
                    <flux:label for="fecha_nacimiento">Fecha de nacimiento</flux:label>
                    <p>{{ $inquilinoSeleccionado->fecha_nacimiento }}</p>
                </div>

                <div>
                    <flux:label for="documento_identidad">Documento de identidad </flux:label>
                    <p>{{ $inquilinoSeleccionado->documento_identidad }}</p>
                </div>
                @endif
               

                <br><br>

                <div class="flex justify-end">
                    <flux:modal.close name="show-inquilino" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>

                    
                </div>

          

        </div>
    </flux:modal>


    {{-- Modal para la vista edit inquilinos --}}
    <flux:modal name="edit-inquilino" class="md:w-96" style="width: 600px" wire:model="editModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar datos del inquilino</flux:heading>
                <flux:text class="mt-2">Llene todos los campos requeridos</flux:text>
            </div>

            <form wire:submit.prevent="update" class="space-y-4">
                <div>
                    <flux:label for="nombres">Nombres <b>(*)</b></flux:label>
                    <flux:input type="text" id="nombres" wire:model="editNombres" required />
                    @error('nombres')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="email">Email <b>(*)</b></flux:label>
                    <flux:input type="email" id="email" wire:model="editEmail" required />
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="telefono">Teléfono <b>(*)</b></flux:label>
                    <flux:input type="text" id="telefono" wire:model="editTelefono" required />
                    @error('telefono')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="fecha_nacimiento">Fecha de nacimiento <b>(*)</b></flux:label>
                    <flux:input type="date" id="fecha_nacimiento" wire:model="editFechaNacimiento" required />
                    @error('fecha_nacimiento')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <flux:label for="documento_identidad">Documento de identidad <b>(*)</b></flux:label>
                    <flux:input type="text" id="documento_identidad" wire:model="editDocumentoIdentidad" required />
                    @error('documento_identidad')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
               

                <br><br>

                <div class="flex justify-end">
                    <flux:modal.close name="edit-inquilino" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="primary">Actualizar Inquilino</flux:button>
                </div>

            </form>

        </div>
    </flux:modal>

     {{-- Modal para la confirmacion de borrado de inquilinos --}}
    <flux:modal name="delete-inquilino" class="min-w-[22rem]" wire:model="deleteModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar registro?</flux:heading>
                <flux:text class="mt-2">
                    <p>Estas a punto de eliminar este inquilino</p>
                    <p>Esta acción no se puede deshacer</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                 <flux:modal.close name="delete-inquilino" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>
                <flux:button type="submit" wire:click="delete" variant="danger">Eliminar registro</flux:button>
            </div>
        </div>
    </flux:modal>


    @if (session('message'))
        <div x-data x-init="Swal.fire({
            icon: 'success',
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 2000,
        })">
        </div>
    @endif


</div>
