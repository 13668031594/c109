<?php

namespace App\Http\Controllers\Admin\Prompt;

use App\Http\Classes\Admin\Prompt\PromptClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use Illuminate\Http\Request;

class PromptController extends AdminController implements ListInterface
{
    private $classes;
    protected $view_dir = 'Prompt.';

    public function __construct()
    {
        $this->classes = new PromptClass();
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
        return parent::views('prompt');
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/prompt/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $result = [
            'self' => $self,
        ];

        return parent::views('prompt', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id,$request);

        $this->classes->update($id,$request);

        return parent::success('/admin/prompt/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',',$request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }
}
