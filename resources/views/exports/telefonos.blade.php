<table>
    <thead>
    <tr>
        <th>Teléfono</th>
        <th>Móvil</th>
        <th>Ciudad</th>
        <th>Provincia</th>
    </tr>
    </thead>
    <tbody>
    @foreach($telefonos as $telefono)
    <tr>
        <td>{{ $telefono->telefono }}</td>
        <td>{{ $telefono->movil }}</td>
        <td>{{ $telefono->city->name }}</td>
        <td>{{ $telefono->city->state->name }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
