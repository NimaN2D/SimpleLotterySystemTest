@extends('master')

@section('body')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Yes Admin!</h1>
        <h1 class="h5"><a href="{{ route('admin.lottery.create') }}">Create new lottery</a></h1>
    </div>

    @if($lotteries->count() > 0)
        <h2>Lotteries list</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Creator</th>
                    <th scope="col">Maximum Winners</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Due At</th>
                    <th scope="col">Is Held</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lotteries AS $lottery)
                    <tr>
                        <td>{{ $lottery->id }}</td>
                        <td>{{ $lottery->name }}</td>
                        <td>{{ $lottery->creator->full_name}}</td>
                        <td>{{ $lottery->maximum_winners }}</td>
                        <td>{{ $lottery->created_at->diffForHumans() }}</td>
                        <td>{{ ($lottery->due_date AND !$lottery->is_held) ? $lottery->due_date->diffForHumans() : '--' }}</td>
                        <td>{{ $lottery->is_held ? 'True' : 'False' }}</td>
                        <td>
                            @if($lottery->is_held)
                                <i class="feather-check"></i>
                                <i>{{ $lottery->updated_at->diffForHumans() }}</i>
                                <br/>
                                <a class="btn btn-sm btn-success" href="{{ route('admin.lottery.winners',['lottery' => $lottery]) }}">Winners List</a>
                            @else
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.lottery.edit',['lottery' => $lottery]) }}">Edit</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.lottery.run',['lottery' => $lottery]) }}">Run Now</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $lotteries->render() }}
        </div>
    @else
        <p>
            No lotteries yet!
        </p>
    @endif
@endsection
