<?php

namespace App\Livewire;

use App\Models\Inquilino;
use Livewire\Component;
use Livewire\WithPagination;

class Inquilinos extends Component
{

    use WithPagination;
    protected $paginationTheme = 'tailwind';

    //campos del formulario de creacion
    public $nombres;
    public $email;  
    public $telefono;
    public $fecha_nacimiento;
    public $documento_identidad;
    
    //campos del formulario de edicion
    public $editNombres;
    public $editEmail;
    public $editTelefono;
    public $editFechaNacimiento;
    public $editDocumentoIdentidad;

    //control de modales
    public $createModal = false;
    public $showModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $inquilinoSeleccionado;
    public $inquilinoEditando;
    public $inquilinoEliminar;

    //reglas de validación
    protected $rules = [
        'nombres' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:inquilinos,email',
        'telefono' => 'required|string|max:20',
        'fecha_nacimiento' => 'required|date',
        'documento_identidad' => 'required|string|max:20|unique:inquilinos,documento_identidad',
    ];

    //Resetear campos del formulario de creación
    public function resetCreateForm()
    {
        $this->reset(['nombres', 'email', 'telefono', 'fecha_nacimiento', 'documento_identidad']);
        $this->resetErrorBag();
    }

    //Resetear campos del formulario de edicion
    public function resetEditForm()
    {
        $this->reset(['editNombres', 'editEmail', 'editTelefono', 'editFechaNacimiento', 'editDocumentoIdentidad', 'inquilinoEditando']);
        $this->resetErrorBag();
    }   

    //Mostrar modal de creación
    public function openCreateModal()
    {
        $this->resetCreateForm();
        $this->createModal = true;
    }

    //Guardar nuevo inquilino
    public function save()
    {
        $this->validate();  
        Inquilino::create([
            'nombres' => $this->nombres,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'documento_identidad' => $this->documento_identidad,
        ]); 
        $this->resetCreateForm();
        $this->createModal = false;
        session()->flash('message', 'Inquilino creado exitosamente');
    }

    //mostrar detalles del inquilino
    public function show($id)
    {
        $this->inquilinoSeleccionado = Inquilino::findOrFail($id);
        $this->showModal = true;
    }

    //mostrar detalles del inquilino en el modal de edicion
    public function edit($id)
    {
        $this->inquilinoEditando = Inquilino::findOrFail($id);
        $this->editNombres = $this->inquilinoEditando->nombres;
        $this->editEmail = $this->inquilinoEditando->email;
        $this->editTelefono = $this->inquilinoEditando->telefono;
        $this->editFechaNacimiento = $this->inquilinoEditando->fecha_nacimiento;
        $this->editDocumentoIdentidad = $this->inquilinoEditando->documento_identidad;   
        
        $this->editModal = true;
    }

    //Actualizar inquilino
    public function update()
    {
        $this->validate([
            'editNombres' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255|unique:inquilinos,email,' . $this->inquilinoEditando->id,
            'editTelefono' => 'required|string|max:20',
            'editFechaNacimiento' => 'required|date',
            'editDocumentoIdentidad' => 'required|string|max:20|unique:inquilinos,documento_identidad,' . $this->inquilinoEditando->id,
        ]);

        $this->inquilinoEditando->update([
            'nombres' => $this->editNombres,
            'email' => $this->editEmail,
            'telefono' => $this->editTelefono,
            'fecha_nacimiento' => $this->editFechaNacimiento,
            'documento_identidad' => $this->editDocumentoIdentidad,
        ]);

        $this->resetEditForm();
        $this->editModal = false;
        session()->flash('message', 'Inquilino actualizado exitosamente');
    }

    //confirmar eliminación de inquilino
    public function confirmDelete($id)
    {
        $this->inquilinoEliminar = Inquilino::findOrFail($id);
        $this->deleteModal = true;
    }

    //eliminar inquilino
    public function delete()
    {
        $inquilino = Inquilino::findOrFail($this->inquilinoEliminar->id);
        $inquilino->delete();

        $this->deleteModal = false;
        $this->inquilinoEliminar = null;
        session()->flash('message', 'Inquilino eliminado exitosamente');

        $inquilinos = Inquilino::paginate(10);
        if($inquilinos->isEmpty() && $this->page > 1) {
            $this->previousPage();
        }
    }

    public function render()
    {
        $inquilinos = Inquilino::paginate(10);
        return view('livewire.inquilinos',compact('inquilinos'));
    }
}
