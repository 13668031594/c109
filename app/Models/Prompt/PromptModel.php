<?php

namespace App\Models\Prompt;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Prompt\PromptModel
 *
 * @property int $id
 * @property string $young_title 标题
 * @property string $young_keyword 关键字
 * @property string $young_content 内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel whereYoungContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel whereYoungKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prompt\PromptModel whereYoungTitle($value)
 * @mixin \Eloquent
 */
class PromptModel extends Model
{
    //
}
