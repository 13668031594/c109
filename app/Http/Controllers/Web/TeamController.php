<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\Team\HostingClass;
use App\Http\Classes\Index\Team\TeamClass;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends WebController
{
    protected $view_dir = 'Team.';

    public function index()
    {
        $class = new TeamClass();

        $member = $class->get_member();

        $child = $class->team($member['uid']);

        $member_model = new MemberModel();

        $team = $class->child_all($member['uid']);

        $result = [
            'child' => $child,
            'status' => $member_model->status,
            'act' => $member_model->act,
            'team' => json_encode($team['team']),
        ];

        return parent::views('tuandui', $result);
    }

    public function hosting(Request $request)
    {
        $class = new HostingClass();

        //初始化托管类
        $class = new HostingClass();

        //验证托管资格
        $member = $class->test($request);

        auth('web')->logout();
        auth('web')->login($member);

        return parent::success();
    }
}
