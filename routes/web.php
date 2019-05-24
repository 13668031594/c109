<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('test/{id}', 'Api\Order\BuyController@pay');

Route::get('plan', 'Plan\PlanController@index');
Route::get('c104', 'Plan\PlanController@gxd_with');

Route::get('test', function () {

    \DB::beginTransaction();

    $member = new \App\Models\Member\MemberModel();
    $members = $member->all();
    foreach ($members as $v){

        $v->young_formal_time = date('Y-m-d H:i:s',strtotime('+90 day',strtotime($v->created_at)));
        $v->save();
    }

    $set = new \App\Http\Classes\Set\SetClass();
    $set = $set->index();

    $order = new \App\Models\Order\BuyOrderModel();

    $orders = $order->where('young_total', '>=', $set['type01'])
        ->where('young_status', '>=', 70)
        ->orderBy('young_tail_end', 'asc')
        ->get()
        ->groupBy('uid')
        ->toArray();

    $member->where('young_formal', '=', '10')->whereIn('uid', array_keys($orders))->update(['young_formal' => '20']);

    foreach ($orders as $v) {

        $user = $member->find($v[0]['uid']);
        if ($v[0]['young_tail_end'] > $user->young_formal_time) {

            $user->young_formal_time = date('Y-m-d H:i:s', strtotime('+30 day', strtotime($v[0]['young_tail_end'])));
        } else {

            $user->young_formal_time = date('Y-m-d H:i:s', strtotime('+30 day', strtotime($user->young_formal_time)));
        }

        if ($user->young_formal_time < date('Y-m-d H:i:s', strtotime('-90 day'))) {
            $user->young_type = 20;
            $user->young_type_time = $user->young_formal_time;
        }elseif ($user->young_type == '20'){

            $user->young_type = 10;
        }
        $user->save();
    }

//    dd($orders);

    \DB::commit();
});