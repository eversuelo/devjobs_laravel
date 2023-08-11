<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @forelse ($vacantes as $vacante)
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="leading-10">
                    <a href="#" class="text-xl font-bold">
                        {{ $vacante->titulo }}
                    </a>
                    <p class="text-sm text-gray-600 font-bold">{{ $vacante->empresa }}</p>
                    <p class="text-sm text-gray-500">Ultimo día: {{ $vacante->ultimo_dia->format('d/m/Y') }}</p>
                </div>
                <div class="flex felx-col  md:flex-row gap-3 mt-10 py-5 md:mt-0 items-stretch">
                    <a href="{{route('candidatos.index',$vacante->id)}}"
                        class="bg-slate-800 py-2 px-4 rounded-lg text-white font-bold uppercase text-center">Candidatos</a>
                    <a href="{{route('vacante.show',$vacante->id)}}"
                        class="bg-green-800 py-2 px-4 rounded-lg text-white font-bold uppercase text-center">Ver Vacante</a>

                    <a href="{{ route('vacantes.edit', $vacante->id) }}"
                        class="bg-blue-800 py-2 px-4 rounded-lg text-white font-bold uppercase text-center">Editar</a>

                    <button href="#"
                        class="bg-red-800 py-2 px-4 rounded-lg text-white font-bold uppercase text-center"
                        wire:click="$emit('mostrarAlerta',{{$vacante->id}})">Eliminar</button>
                </div>
            </div>

        @empty
            <p class="text-center p- text-sm text-gray-600">No hay vacantes que mostrar.</p>
        @endforelse
    </div>
    <div class="  mt-10">
        {{ $vacantes->links() }}
    </div>
</div>
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        Livewire.on('mostrarAlerta', (vacanteId) => {

            // El siguiente código es el Alert utilizado

            Swal.fire({
                title: '¿Deseas eliminar la vacante?',
                text: "Una vex eliminada no se puede recuperar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('eliminarVacante',vacanteId);
                    Swal.fire(
                        'Se elimino la vacante!',
                        'Eliminado Correctanemnte',
                        'success'
                    )
                }
            })
        });
    </script>
@endpush
