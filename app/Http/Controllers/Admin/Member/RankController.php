<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Classes\Member\MemberRankClass;
use App\Http\Classes\Member\WalletClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberRecordModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class RankController extends AdminController implements ListInterface
{
    private $classes;
    protected $view_dir = 'MemberRank.';

    public function __construct()
    {
        $this->classes = new MemberRankClass();
    }

    public function index()
    {
        return parent::views('index');
    }

    public function table()
    {
        $result = $this->classes->index();

        return parent::tables($result);
    }

    public function show(Request $request)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(Request $request)
    {
        $result['self'] = $this->classes->edit($request->get('id'));

        return parent::views('rank', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/rank/index');
    }

    public function destroy(Request $request)
    {

    }

}
