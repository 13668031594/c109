<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Index\User\UserClass;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends WebController
{
    protected $view_dir = 'Wallet.';

    public function index()
    {
        $class = new IndexClass();

        $member = $class->get_member();

        return parent::views('qianbao', ['member' => $member]);
    }

    public function record()
    {
        $wallet = \request()->get('wallet');


        return parent::views('record', ['wallet' => $wallet]);
    }

    public function wallet_table(Request $request)
    {
        $class = new UserClass();

        $member = $class->get_member();

        $request->request->add(['id' => $member['uid']]);

        $result = $class->record_table($request);

        $model = new MemberWalletModel();

        $type = $model->type;

        foreach ($result['message'] as &$v)$v['type_name'] = $type[$v['type']];

        return parent::tables($result);
    }
}
