<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // 定义 fillable 属性，来指定在微博模型中可以进行正常更新的字段。否则会抛出MassAssignmentException异常
    protected $fillable = ['content'];

    public function user()
    {
        // 微博模型中，指明一条微博属于一个用户
        return $this->belongsTo(User::class);
    }
}