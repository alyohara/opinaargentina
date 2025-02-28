<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle de Persona') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Datos Generales</h3>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $personaT->id }}</td>
                        </tr>
                        <tr>
                            <th>Apellido y Nombre</th>
                            <td>{{ $personaT->apellido_y_nombre }}</td>
                        </tr>
                        <tr>
                            <th>DNI</th>
                            <td>{{ $personaT->dni }}</td>
                        </tr>
                        <tr>
                            <th>Direccion</th>
                            <td>{{ $personaT->direccion }}</td>
                        </tr>
                        <tr>
                            <th>Año Nacimiento</th>
                            <td>{{ $personaT->anio_nacimiento }}</td>
                        </tr>
                        <tr>
                            <th>Genero</th>
                            <td>{{ $personaT->genero }}</td>
                        </tr>
                        <tr>
                            <th>Nacionalidad</th>
                            <td>{{ $personaT->nacionalidad }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $personaT->email }}</td>
                        </tr>
                        <tr>
                            <th>Dato extra 1</th>
                            <td>{{ $personaT->dato_extra_1 }}</td>
                        </tr>
                        <tr>
                            <th>Dato extra 2</th>
                            <td>{{ $personaT->dato_extra_2 }}</td>
                        </tr>
                        <tr>
                            <th>Telefono</th>
                            <td>{{ $personaT->telefono }}</td>
                        </tr>
                        <tr>
                            <th>Movil</th>
                            <td>{{ $personaT->movil }}</td>
                        </tr>
                        <tr>
                            <th>CP</th>
                            <td>{{ $personaT->cp }}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ $personaT->state }}</td>
                        </tr>
                        <tr>
                            <th>Localidad</th>
                            <td>{{ $personaT->localidad ? $personaT->localidad->nombre : '' }}</td>
                        </tr>
                        <tr>
                            <th>Provincia</th>
                            <td>{{ $personaT->localidad && $personaT->localidad->provincia ? $personaT->localidad->provincia->nombre : '' }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <h3 class="mb-4">Datos Electorales</h3>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Seccion</th>
                            <td>{{ $personaT->seccion }}</td>
                        </tr>
                        <tr>
                            <th>Circuito</th>
                            <td>{{ $personaT->circuito }}</td>
                        </tr>
                        <tr>
                            <th>Mesa</th>
                            <td>{{ $personaT->mesa }}</td>
                        </tr>
                        <tr>
                            <th>Orden</th>
                            <td>{{ $personaT->orden }}</td>
                        </tr>
                        <tr>
                            <th>Establecimiento</th>
                            <td>{{ $personaT->establecimiento }}</td>
                        </tr>
                        <tr>
                            <th>Direccion Establecimiento</th>
                            <td>{{ $personaT->direccion_establecimiento }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('personas_t.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
