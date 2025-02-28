<div class="mb-3">
    <label for="apellido_y_nombre" class="form-label">Apellido y Nombre</label>
    <input type="text" class="form-control" id="apellido_y_nombre" name="apellido_y_nombre" value="{{ isset($personaT) ? $personaT->apellido_y_nombre : old('apellido_y_nombre') }}">
    @error('apellido_y_nombre')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dni" class="form-label">DNI</label>
    <input type="number" class="form-control" id="dni" name="dni" value="{{ isset($personaT) ? $personaT->dni : old('dni') }}">
    @error('dni')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ isset($personaT) ? $personaT->direccion : old('direccion') }}">
    @error('direccion')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="anio_nacimiento" class="form-label">Año de nacimiento</label>
    <input type="number" class="form-control" id="anio_nacimiento" name="anio_nacimiento" value="{{ isset($personaT) ? $personaT->anio_nacimiento : old('anio_nacimiento') }}">
    @error('anio_nacimiento')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="genero" class="form-label">Género</label>
    <input type="text" class="form-control" id="genero" name="genero" value="{{ isset($personaT) ? $personaT->genero : old('genero') }}">
    @error('genero')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nacionalidad" class="form-label">Nacionalidad</label>
    <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="{{ isset($personaT) ? $personaT->nacionalidad : old('nacionalidad') }}">
    @error('nacionalidad')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ isset($personaT) ? $personaT->email : old('email') }}">
    @error('email')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dato_extra_1" class="form-label">Dato Extra 1</label>
    <input type="text" class="form-control" id="dato_extra_1" name="dato_extra_1" value="{{ isset($personaT) ? $personaT->dato_extra_1 : old('dato_extra_1') }}">
    @error('dato_extra_1')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dato_extra_2" class="form-label">Dato Extra 2</label>
    <input type="text" class="form-control" id="dato_extra_2" name="dato_extra_2" value="{{ isset($personaT) ? $personaT->dato_extra_2 : old('dato_extra_2') }}">
    @error('dato_extra_2')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ isset($personaT) ? $personaT->telefono : old('telefono') }}">
    @error('telefono')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="movil" class="form-label">Móvil</label>
    <input type="text" class="form-control" id="movil" name="movil" value="{{ isset($personaT) ? $personaT->movil : old('movil') }}">
    @error('movil')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="cp" class="form-label">CP</label>
    <input type="number" class="form-control" id="cp" name="cp" value="{{ isset($personaT) ? $personaT->cp : old('cp') }}">
    @error('cp')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="seccion" class="form-label">Sección</label>
    <input type="text" class="form-control" id="seccion" name="seccion" value="{{ isset($personaT) ? $personaT->seccion : old('seccion') }}">
    @error('seccion')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="circuito" class="form-label">Circuito</label>
    <input type="text" class="form-control" id="circuito" name="circuito" value="{{ isset($personaT) ? $personaT->circuito : old('circuito') }}">
    @error('circuito')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="mesa" class="form-label">Mesa</label>
    <input type="number" class="form-control" id="mesa" name="mesa" value="{{ isset($personaT) ? $personaT->mesa : old('mesa') }}">
    @error('mesa')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="orden" class="form-label">Orden</label>
    <input type="number" class="form-control" id="orden" name="orden" value="{{ isset($personaT) ? $personaT->orden : old('orden') }}">
    @error('orden')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="establecimiento" class="form-label">Establecimiento</label>
    <input type="text" class="form-control" id="establecimiento" name="establecimiento" value="{{ isset($personaT) ? $personaT->establecimiento : old('establecimiento') }}">
    @error('establecimiento')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="direccion_establecimiento" class="form-label">Dirección del Establecimiento</label>
    <input type="text" class="form-control" id="direccion_establecimiento" name="direccion_establecimiento" value="{{ isset($personaT) ? $personaT->direccion_establecimiento : old('direccion_establecimiento') }}">
    @error('direccion_establecimiento')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="state" class="form-label">State</label>
    <input type="text" class="form-control" id="state" name="state" value="{{ isset($personaT) ? $personaT->state : old('state') }}">
    @error('state')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="provincia" class="form-label">Provincia</label>
        <select id="provincia" name="provincia" class="form-control select2">
            <option value="">Seleccione una provincia</option>
            @foreach(\App\Models\Provincia::all() as $provincia)
                <option value="{{ $provincia->id }}"
                >
                    {{ $provincia->nombre }}
                </option>
            @endforeach
        </select>
        @error('provincia')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="localidad" class="form-label">Localidad</label>
        <select id="localidad" name="localidad_id" class="form-control select2">
            <option value="">Seleccione una localidad</option>
        </select>
        @error('localidad_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
