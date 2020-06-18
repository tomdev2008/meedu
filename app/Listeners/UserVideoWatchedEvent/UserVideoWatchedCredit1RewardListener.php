<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserVideoWatchedEvent;

use App\Constant\FrontendConstant;
use App\Events\UserVideoWatchedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\CreditService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;

class UserVideoWatchedCredit1RewardListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @var CreditService
     */
    protected $creditService;

    /**
     * RegisterCredit1RewardListener constructor.
     * @param ConfigServiceInterface $configService
     * @param CreditServiceInterface $creditService
     */
    public function __construct(ConfigServiceInterface $configService, CreditServiceInterface $creditService)
    {
        $this->configService = $configService;
        $this->creditService = $creditService;
    }

    /**
     * Handle the event.
     *
     * @param UserVideoWatchedEvent $event
     * @return void
     */
    public function handle(UserVideoWatchedEvent $event)
    {
        $credit1 = $this->configService->getWatchedVideoSceneCredit1();
        if ($credit1 <= 0) {
            return;
        }

        $this->creditService->createCredit1Record($event->userId, $credit1, __(FrontendConstant::CREDIT1_REMARK_WATCHED_VIDEO));
    }
}