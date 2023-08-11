<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\WithFileUploads;

class PostularVacante extends Component
{
    public $cv;
    public $vacante;
    protected $rules = [
        "cv" => 'required|mimes:pdf|max:2048'
    ];
    use WithFileUploads;
    public function mount(Vacante $vacante)
    {
        $this->vacante = $vacante;
    }
    public function postularme()
    {
        $datos = $this->validate();
        //Almacenar CV en el HDD
        $cv = $this->cv->store('public/postulaciones');
        $datos['cv'] = str_replace('public/postulaciones', '', $cv);


        //cREAR El candidato a la vacante
        $this->vacante->candidatos()->create([
            'user_id' => auth()->user()->id,
            'cv'=>$datos['cv'],
        ]);
          //cREAR notificacion

          $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id,$this->vacante->titulo,auth()->user()->id));

        //Mostrar Mensaje
        session()->flash('mensaje','Se envio correctamente tu información, mucha suerte');

        return redirect()->back();
      
    }
    public function render()
    {

        return view('livewire.postular-vacante');
    }
}
