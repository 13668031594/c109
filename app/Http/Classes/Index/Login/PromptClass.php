<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/11
 * Time: 下午3:23
 */

namespace App\Http\Classes\Index\Login;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\FwbTrait;
use App\Models\Prompt\PromptModel;

class PromptClass extends IndexClass
{
    use FwbTrait;

    public function prompt($keyword)
    {
        $model = new PromptModel();

        $prompt = $model->where('young_keyword', '=', $keyword)->first();

        if (is_null($prompt)) parent::error_json('没有内容');

        $content = $this->completion_location($prompt->young_content);

        return $content;
    }
}