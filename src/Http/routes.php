<?php

Route::group(['middleware' => ['web']], function () {

    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]], function() {
        Route::get('{slug}', ['uses' => 'Wislem\Berrier\Http\Controllers\Modules\Pages\PageFrontController@index']);
        Route::get('p/{slug}', ['uses' => 'Wislem\Berrier\Http\Controllers\Modules\Posts\PostFrontController@index']);
        Route::get('c/{slug}', ['uses' => 'Wislem\Berrier\Http\Controllers\Modules\Categories\CategoryFrontController@index']);
    });

    Route::get('admin/auth/login', ['uses' => 'Wislem\Berrier\Http\Controllers\AuthController@getLogin']);
    Route::post('admin/auth/login', ['uses' => 'Wislem\Berrier\Http\Controllers\AuthController@postLogin']);
    Route::get('admin/auth/logout', ['uses' => 'Wislem\Berrier\Http\Controllers\AuthController@getLogout']);

    Route::group(['prefix' => 'admin', 'namespace' => 'Wislem\Berrier\Http\Controllers', 'middleware' => ['berrier.auth']], function () {

        Route::get('fixtree', function () {
            \Wislem\Berrier\Models\Category::fixTree();
        });

        Route::get('/', ['uses' => 'BerrierController@dashboard']);
        Route::post('ajax/slug-it', ['uses' => 'AjaxController@slugIt']);

        Route::resource('categories', 'Modules\Categories\CategoryController', ['except' => 'show']);
        Route::patch('categories/{id}/move', ['uses' => 'Modules\Categories\CategoryController@move']);
        Route::resource('pages', 'Modules\Pages\PageController', ['except' => 'show']);
        Route::post('pages/grid', 'Modules\Pages\PageController@grid');
        Route::resource('posts', 'Modules\Posts\PostController', ['except' => 'show']);
        Route::post('posts/grid', 'Modules\Posts\PostController@grid');
        Route::resource('menus', 'Modules\Menus\MenuController', ['except' => 'show']);
        Route::post('menus/grid', 'Modules\Menus\MenuController@grid');
        Route::resource('widgets', 'Modules\Widgets\WidgetController', ['except' => 'show']);
        Route::post('widgets/grid', 'Modules\Widgets\WidgetController@grid');
        Route::resource('settings', 'Modules\Settings\SettingController', ['except' => 'show']);
        Route::post('settings/grid', 'Modules\Settings\SettingController@grid');
        Route::resource('users', 'Modules\Users\UserController', ['except' => 'show']);
        Route::post('users/grid', 'Modules\Users\UserController@grid');
        Route::resource('usettings', 'Modules\UserSettings\UserSettingController', ['except' => 'show']);
        Route::post('usettings/grid', 'Modules\UserSettings\UserSettingController@grid');
        Route::resource('notifications', 'Modules\Notifications\NotificationController', ['except' => 'show']);

        Route::resource('media', 'Modules\Media\MediaController', ['only' => ['store', 'destroy']]);
    });

});