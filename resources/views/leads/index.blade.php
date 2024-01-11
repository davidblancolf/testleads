@extends('components.layout',['title'=>'Leads'])
@section('content')
@if(session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
@endif
@if(session('danger'))
 <div class="alert alert-danger">
    {{ session('danger') }}
    </div>
@endif
<a class="btn btn-primary" href="{{ route('web.leads.create') }}">{{ __('Create Lead') }}</a>
   <table class="table">
        <thead>
            <tr>
                <th scope="col">{{ __('NAME') }}</th>
                <th scope="col">{{ __('EMAIL') }}</th>
                <th scope="col">{{ __('PHONE') }}</th>
                <th scope="col">{{ __('OPTIONS') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leads as $lead)
                <tr>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->email }}</td>
                    <td>{{ $lead->phone }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('leads.show',['lead'=>$lead]) }}">{{ __('VIEW') }}</a>
                        <a class="btn btn-primary" href="{{ route('leads.edit',['lead'=>$lead]) }}">{{ __('EDIT') }}</a>
                        <form action="{{ route('leads.destroy',['lead'=>$lead]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('DELETE') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
   </table>
   <div class="d-flex justify-content-center mt-4">
        {{ $leads->links() }}
   </div>
@endsection
