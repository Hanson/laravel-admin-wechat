<?php

namespace Hanson\LaravelAdminWechat\Jobs;

use Carbon\Carbon;
use Hanson\LaravelAdminWechat\Facades\ConfigService;
use Hanson\LaravelAdminWechat\Models\WechatUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $appId;

    /**
     * Create a new job instance.
     *
     * @param string $appId
     */
    public function __construct(string $appId)
    {
        $this->appId = $appId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $app = ConfigService::getInstanceByAppId($this->appId);

        $nextOpenId = null;

        while (true) {
            $list = $app->user->list($nextOpenId);

            $nextOpenId = $list['next_openid'];

            if (!$list['count']) {
                return;
            }

            $result = $app->user->select($list['data']['openid']);

            foreach ($result['user_info_list'] as $user) {
                config('admin.extensions.wechat.wechat_user', WechatUser::class)::query()->updateOrCreate([
                    'app_id' => $this->appId,
                    'openid' => $user['openid'],
                ], [
                    'nickname' => $user['nickname'] ?? null,
                    'avatar' => $user['headimgurl'] ?? null,
                    'gender' => $user['sex'] ?? null,
                    'country' => $user['country'] ?? null,
                    'province' => $user['province'] ?? null,
                    'city' => $user['city'] ?? null,
                    'subscribed_at' => $user['subscribe'] ? Carbon::parse($user['subscribe_time'])->toDateTimeString() : null,
                ]);
            }
        }
    }
}
