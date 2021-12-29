<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getCustomersPaginated($order = 'asc') : ?LengthAwarePaginator
    {
        /**@var $entity User*/
        $entity = $this->user->newQuery();
        if(!in_array($order,['desc','asc']))
            $order = 'asc';

        return $entity->customer()->orderBy('id',$order)->paginate();
    }

    public function getCustomersWithoutLotteryInRandomOrder($count = 10) : ?Collection
    {
        /**@var $entity User*/
        $entity = $this->user->newQuery();
        return $entity->customer()->whereDoesntHave('lottery')->inRandomOrder()->take((int)$count)->get();
    }

    public function getCustomersWithoutLotteryPaginated() : ?LengthAwarePaginator
    {
        /**@var $entity User*/
        $entity = $this->user->newQuery();
        return $entity->customer()->whereDoesntHave('lottery')->inRandomOrder()->paginate();
    }

    public function getCustomersCount() : int
    {
        return $this->user->customer()->count();
    }
}
