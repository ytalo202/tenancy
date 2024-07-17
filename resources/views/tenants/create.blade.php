<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inquilinos') }}
        </h2>
    </x-slot>

    <x-container class="py-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('tenants.store')}}" method="POST">
                    @csrf



                    <div class="mb-4">
                        <input-label>Nombre</input-label>
                        <x-text-input name="id" type="text" class="w-full mt-2" placeholder="Ingrese el nombreNombre" value="{{old('id')}}" />
                        <x-input-error :messages="$errors->first('id')"/>
                    </div>


                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-blue">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-container>

</x-app-layout>
