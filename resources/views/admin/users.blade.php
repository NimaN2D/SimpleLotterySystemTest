@extends('master')

@section('body')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users List</h1>
    </div>

    @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Lottery</th>
                    <th scope="col">Joined At</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users AS $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->lottery->count())
                                <i>{{ $user->lottery_name }}</i> at <i>{{ $user->lottery_win_date }}</i>
                            @else
                                ---
                            @endif
                        </td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br />
            {{ $users->links() }}
        </div>
    @else
        <p>
            No lotteries yet!
        </p>
    @endif
@endsection
