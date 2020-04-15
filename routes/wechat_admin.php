<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('admin.route.prefix').'/wechat',
    'namespace' => 'Hanson\\LaravelAdminWechat\\Http\\Controllers\\Admin',
    'middleware' => config('admin.route.middleware'),
], function () {
    Route::resources([
        'configs' => 'ConfigController',
    ]);

    // 公众号操作
    Route::group(['prefix' => 'official-account', 'namespace' => 'OfficialAccount'], function () {
        Route::resources('cards', 'CardController');
        Route::resource('users', 'UserController')->names([
            'index' => 'official-account.users.index',
            'store' => 'official-account.users.store',
            'show' => 'official-account.users.show',
            'create' => 'official-account.users.create',
            'edit' => 'official-account.users.edit',
            'update' => 'official-account.users.update',
            'destroy' => 'official-account.users.destroy',
        ]);
        Route::get('menu', 'MenuController@index')->name('admin.wechat.menu');
        Route::post('menu', 'MenuController@store')->name('admin.wechat.menu.update');

    });

    // 小程序操作
    Route::group(['prefix' => 'mini-program', 'namespace' => 'MiniProgram'], function () {
        Route::resource('users', 'UserController')->names([
            'index' => 'mini-program.users.index',
            'store' => 'mini-program.users.store',
            'show' => 'mini-program.users.show',
            'create' => 'mini-program.users.create',
            'edit' => 'mini-program.users.edit',
            'update' => 'mini-program.users.update',
            'destroy' => 'mini-program.users.destroy',
        ]);
    });

    // 支付操作
    Route::group(['prefix' => 'payment', 'namespace' => 'Payment'], function () {
        Route::resources([
            'merchants' => 'MerchantController',
        ]);
    });
});
