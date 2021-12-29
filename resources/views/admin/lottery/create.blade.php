@extends('master')

@section('body')
    <div class="card-body">
        <form method="POST" action="{{ !isset($lottery) ? route('admin.lottery.store') :  route('admin.lottery.update',['lottery' => $lottery]) }} ">
            @csrf
            @isset($lottery->id)
                {{ method_field('PATCH')}}
            @endisset
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Lottery Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($lottery) ? $lottery->name : '') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="maximum_winners" class="col-md-4 col-form-label text-md-end">{{ __('Maximum Winners') }}</label>

                <div class="col-md-6">
                    <input id="maximum_winners" type="number" class="form-control @error('maximum_winners') is-invalid @enderror" name="maximum_winners" value="{{ old('maximum_winners', isset($lottery) ? $lottery->maximum_winners : '') }}" required autocomplete="maximum_winners" autofocus>

                    @error('maximum_winners')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="due_date" class="col-md-4 col-form-label text-md-end">{{ __('Due Date') }}</label>

                <div class="col-md-6">
                    <input id="due_date" type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date', isset($lottery) ? $lottery->due_date->format('Y-m-d') : '') }}" required autocomplete="maximum_winners" autofocus>

                    @error('due_date')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
