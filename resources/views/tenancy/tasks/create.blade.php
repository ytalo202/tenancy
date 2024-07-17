<x-tenancy-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tareas') }}
        </h2>
    </x-slot>

    <x-container class="py-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('tasks.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf



                    <div class="mb-4">
                        <x-input-label>Nombre</x-input-label>
                        <x-text-input name="name" type="text" class="w-full mt-2" placeholder="Ingrese el nombre" value="{{old('name')}}" />
                        <x-input-error :messages="$errors->first('name')"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label>Descripción</x-input-label>
{{--                        <x-text-input name="description" type="text" class="w-full mt-2" placeholder="Ingrese las descripción" value="{{old('description')}}" />--}}
{{--                        <x-input-error :messages="$errors->first('description')"/>--}}

                        <textarea name="description" class="form-control w-full" placeholder="Ingrese una breve descripción">{{old('description')}}</textarea>
                        <x-input-error :messages="$errors->first('description')"/>
                    </div>


                    <div class="mb-4">
                        <x-input-label>Imagen</x-input-label>

                        <input type="file" class="mt-2" name="image_url">
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

</x-tenancy-layout>
