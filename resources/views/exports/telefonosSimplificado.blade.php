<table>
    <thead>
    <tr>
        <th>Telefono</th>
        <th>Localidad</th>
    </tr>
    </thead>
    <tbody>
    @foreach($telefonos as $telefono)
        <tr>
            <td>{{ $telefono['telefono'] }}</td>
            <td>{{ $telefono['localidad'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
