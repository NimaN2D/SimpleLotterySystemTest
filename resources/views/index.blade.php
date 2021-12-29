@extends('master')

@section('body')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            @auth()
                Welcome Dear {{ auth()->user()->full_name }}
            @else
                Welcome Buddy
            @endauth
        </h1>
    </div>
    <p>
        @if(auth()->check() AND auth()->user()->lottery()->exists())
            <span class="alert alert-success p-lg-1 ">
                Congratulation! You are selected in lottery {{ auth()->user()->lottery_name }}
            </span>
        @else
            YoYo!! You are here... <br />
            We proud of us ! <br />

            We held <b>{{ app(\App\Repositories\LotteryRepository::class)->getFinishedLotteriesCount() }}</b> Lotteries, <br />
            and we have <b>{{ app(\App\Repositories\UserRepository::class)->getCustomersCount() }}</b> users .
        @endif
    </p>
@endsection
