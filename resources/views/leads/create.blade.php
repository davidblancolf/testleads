@extends('components.layout',['title'=>'Crear Lead'])
@section('content')
<div>
   <form method="POST" action="{{ route('web.leads.store') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
        <label for="nombre" class="form-label">{{ __('NAME') }}:</label>
        <input type="text" name="name" class=" form-control @error('name') is-invalid @else is-valid @enderror" value="{{ old('nombre') }}">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('EMAIL') }}:</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @else is-valid @enderror" value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">{{ __('PHONE') }}:</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @else is-valid @enderror" value="{{ old('phone') }}">
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">{{ __('SAVE') }}</button>
        <a href="{{ URL::previous() }}" class="btn btn-secondary">{{ __('CANCEL') }}</a>
   </form>
</div>
@endsection
