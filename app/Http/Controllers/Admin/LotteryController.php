<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLotteryRequest;
use App\Http\Requests\UpdateLotteryRequest;
use App\Models\Lottery;
use App\Repositories\LotteryRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LotteryController extends Controller
{

    private $lotteryRepository;
    private $userRepository;

    public function __construct(LotteryRepository $lotteryRepository, UserRepository $userRepository)
    {
        $this->lotteryRepository = $lotteryRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lotteries = $this->lotteryRepository->getLotteriesPaginated();
        return view('admin.dashboard',[
            'lotteries' => $lotteries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lottery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreLotteryRequest $request)
    {
        $this->lotteryRepository->create($request->safe()->toArray());
        session()->flash('success','Lottery created successfully !');
        return redirect(route('admin.lottery.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lottery $lottery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function edit(Lottery $lottery)
    {
        if($lottery->is_held){
            session()->flash('message',"What's wrong ?");
            return redirect(route('admin.lottery.index'));
        }
        return view('admin.lottery.create',[
            'lottery' => $lottery
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Lottery $lottery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLotteryRequest $request, Lottery $lottery)
    {
        if($lottery->is_held){
            session()->flash('message',"What's wrong ?");
            return redirect(route('admin.lottery.index'));
        }

        $this->lotteryRepository->setLottery($lottery);
        $this->lotteryRepository->update($request->safe()->toArray());
        return redirect(route('admin.lottery.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function doLottery(Lottery $lottery)
    {
        if($lottery->is_held){
            session()->flash('message',"What's wrong ?");
            return redirect(route('admin.lottery.index'));
        }
        $this->lotteryRepository->doLottery($lottery);

        return redirect(route('admin.lottery.index'));
    }

    public function winnersList(Lottery $lottery)
    {
        $lottery->load('winners');
        return view('admin.lottery.winners', [
            'lottery' => $lottery
        ]);
    }
}
