<x-tenancy-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tareas') }}
        </h2>
    </x-slot>

    {{--    <div class="py-12">--}}
    {{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
    {{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
    {{--                <div class="p-6 text-gray-900">--}}
    {{--                    {{ __("You're logged in!") }}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}

    {{--    </div>--}}

    <x-container class="py-12">


        <div class="flex justify-end mb-6">
            <a href="{{route('tasks.create')}}" class="btn btn-blue">
                Nuevo
            </a>
        </div>


        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>

                    <th scope="col" class="px-6 py-3">

                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($tasks as $task)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$task->id}}
                        </th>
                        <td class="px-6 py-4">


                            <p>{{$task->name ?? ''}}</p>

{{--                            {{\Illuminate\Support\Facades\Storage::url($task->image_url)}}--}}

                            <img src="{{route('file',$task->image_url)}}" alt="" style="width: 200px">

                        </td>


                        <td class="px-6 py-4">
                            <div class="flex justify-end mb-6">

                                <form action="{{route('tasks.destroy',$task)}}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-red mr-2">
                                        Eliminar
                                    </button>
                                </form>


                                <a href="{{route('tasks.edit',$task)}}" class="btn btn-green">
                                    Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </x-container>

</x-tenancy-layout>
