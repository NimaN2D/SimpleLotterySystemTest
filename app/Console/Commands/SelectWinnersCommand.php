<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\LotteryRepository;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class SelectWinnersCommand extends Command
{

    private $lotteryRepository;
    private $userRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select winners automatically for finished lotteries';

    /**
     * Create a new command instance.
     *
     * @param LotteryRepository $lotteryRepository
     * @param UserRepository $userRepository
     */
    public function __construct(LotteryRepository $lotteryRepository, UserRepository $userRepository)
    {
        $this->lotteryRepository = $lotteryRepository;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start fetching lotteries one by one...' . PHP_EOL);
        $unfinished_counts = $this->lotteryRepository->getUnFinishedLotteriesCount();
        $this->info("We have {$unfinished_counts} unfinished lotteries..." . PHP_EOL);

        if($unfinished_counts == 0)
            return null;

        $bar = $this->output->createProgressBar();
        $bar->start();

        while($lottery = $this->lotteryRepository->getFirstFinishedLotteryWithOutWinner()) {
            $this->info('Lottery : ' . $lottery->name);
            $users_without_lottery = $this->userRepository->getCustomersWithoutLotteryInRandomOrder($lottery->maximum_winners);
            if($users_without_lottery->count() < $lottery->maximum_winners) {
                $this->error('Inefficient member' . PHP_EOL);
            } else {
                $lottery->winners()->sync($users_without_lottery->pluck('id'));
                $this->info("{$lottery->maximum_winners} defined for {$lottery->name}" . PHP_EOL);
            }
            $bar->advance();
        }

        $bar->finish();

    }
}
