<?php


namespace App\Repositories;


use App\Models\Lottery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LotteryRepository
{
    private $entity;
    private $userRepository;

    public function __construct(Lottery $lottery, UserRepository $userRepository)
    {
        $this->entity = $lottery;
        $this->userRepository = $userRepository;
    }

    public function setLottery(Lottery $lottery)
    {
        $this->entity = $lottery;
    }

    public function create(array $data): Lottery
    {
        /**@var $lottery Lottery */
        $data['creator_id'] = auth()->user()->id;
        $lottery = $this->entity->newQuery()->create($data);
        return $lottery;
    }

    public function update(array $data)
    {
        /**@var $lottery Lottery */
        $lottery = $this->entity->update($data);
        session()->flash('success','Lottery updated successfully .');
        return $lottery;
    }

    public function delete()
    {
        session()->flash('success','Lottery removed successfully .');
        $this->entity->delete();
    }

    public function getLotteriesPaginated($order_by = 'created_at', $order = 'desc', $per_page = 15): LengthAwarePaginator
    {
        if (!in_array($order_by, $this->entity->getFillable()))
            $order_by = 'created_at';

        if (!in_array($order, ['desc', 'asc']))
            $order = 'desc';

        return $this->entity->newQuery()->orderBy($order_by, $order)->paginate((int)$per_page);
    }

    public function getFinishedLotteriesCount(): int
    {
        return $this->entity->newQuery()
            ->where('is_held', '=', true)
            ->count();
    }

    public function getTotalWinnersSum(): int
    {
        return $this->entity->newQuery()
            ->where('is_held', '=', true)
            ->sum('maximum_winners');
    }

    public function getUnFinishedLotteriesCount(): int
    {
        return $this->entity->newQuery()
            ->where('due_date', '<', now()->toDateTimeString())
            ->where('is_held', '=', false)
            ->whereDoesntHave('winners')
            ->count();
    }

    public function getFirstFinishedLotteryWithOutWinner($order = 'desc'): ?Lottery
    {
        /**@var $lottery Lottery */
        if (!in_array(strtolower($order), ['desc', 'asc']))
            $order = 'desc';

        $lottery = $this->entity->newQuery()
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateTimeString())
            ->where('is_held', false)
            ->orderBy('due_date', $order)
            ->whereDoesntHave('winners')
            ->first();
        return $lottery;
    }

    public function doLottery(Lottery $lottery)
    {
        if ($lottery->is_held) {
            session()->flash('error','Lottery ran before !');
            return null;
        }

        $users_without_lottery = $this->userRepository->getCustomersWithoutLotteryInRandomOrder($lottery->maximum_winners);

        if ($users_without_lottery->count() < $lottery->maximum_winners) {
            session()->flash('error','Inefficient member for this lottery,Decrease maximum winners please.');
            return null;
        }

        $lottery->winners()->sync($users_without_lottery->pluck('id'));
        $lottery->update([
            'is_held' => true
        ]);
    }

}
