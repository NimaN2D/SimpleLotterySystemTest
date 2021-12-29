@extends('master')

@section('body')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Winners of lottery {{ $lottery->name }} was held on {{ $lottery->updated_at->format('Y/m/d') }}</h1>
        <h1 class="h5"><a href="{{ route('admin.lottery.create') }}">Create new lottery</a></h1>
    </div>

    @if($lottery->winners->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Full Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lottery->winners AS $winner)
                    <tr>
                        <td>{{ $winner->full_name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>
            Oops,What ?
        </p>
    @endif
@endsection
