<?php


namespace Hanson\LaravelAdminWechat\Http\Controllers\Admin\OfficialAccount;


use Encore\Admin\Grid;
use Hanson\LaravelAdminWechat\Actions\ImportUsers;
use Hanson\LaravelAdminWechat\Http\Controllers\Admin\BaseController;
use Hanson\LaravelAdminWechat\Models\WechatCoupon;
use Hanson\LaravelAdminWechat\Models\WechatFake;
use Hanson\LaravelAdminWechat\Models\WechatUser;

class CouponController extends BaseController
{
    protected $title = '卡券';

    protected function grid()
    {
        $grid = new Grid(new WechatCoupon);

//        $grid->model()->where('app_id', $this->appId);

        return $grid;
    }
}
