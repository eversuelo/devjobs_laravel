<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use App\Models\Categoria;
use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class EditarVacante extends Component
{
    public $vacante_id;
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;
    use WithFileUploads;
    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen_nueva' => 'nullable|image|max:1024',
    ];
    public function mount(Vacante $vacante)
    {
        $this->vacante_id = $vacante->id;
        $this->titulo = $vacante->titulo;
        $this->empresa = $vacante->empresa;
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
        $this->ultimo_dia = Carbon::parse($vacante->ultimo_dia)->format('Y-m-d');
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
    }
    public function editarVacante()
    {
        $datos = $this->validate();
        //Si hay una nueva imagen
        $vacante=Vacante::find($this->vacante_id);
        if ($this->imagen_nueva) {
            $imagen = $this->imagen_nueva->store('public/vacantes');
            $datos['imagen'] = str_replace('public/vacantes/', '', $imagen);
            Storage::delete('public/vacantes' . $vacante->imagen);
        }
        //Encontrar la vacante a editar
        $vacante = Vacante::find($this->vacante_id);
        //Asignar los valores
        $vacante->titulo = $datos['titulo'];
        $vacante->salario_id = $datos['salario'];
        $vacante->categoria_id = $datos['categoria'];
        $vacante->empresa = $datos['empresa'];
        $vacante->ultimo_dia = $datos['ultimo_dia'];
        $vacante->descripcion = $datos['descripcion'];
        $vacante->imagen = $datos['imagen'] ?? $vacante->imagen;
        //Guardar la vacante
        $vacante->save();
        //Redireccionar
        session()->flash('mensaje', 'La vacante se actualizo correctamente.');
        return redirect()->route('vacantes.index');
    }
    public function render()
    {
        //Consultar BD
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.editar-vacante', ['salarios' => $salarios, 'categorias' => $categorias]);
    }
}
