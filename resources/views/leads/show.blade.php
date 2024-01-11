@extends('components.layout',['title'=>'View Lead'])
@section('content')
<div class="container mt-4">
    <table class="table table-bordered">
        <tbody>
        <tr>
                <th>ID</th>
                <td>{{ $lead->id }}</td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $lead->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $lead->email }}</td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>{{ $lead->phone }}</td>
            </tr>
            <tr>
                <th>Scoring</th>
                <td>{{ $lead->scoring }}</td>
            </tr>
            <tr>
                <th>Creado en</th>
                <td>{{ $lead->created_at }}</td>
            </tr>
            <tr>
                <th>Actualizado en</th>
                <td>{{ $lead->updated_at }}</td>
            </tr>

        </tbody>
    </table>
    <a href="{{ URL::previous() }}" class="btn btn-secondary">{{ __('CANCEL') }}</a>
</div>
@endsection
