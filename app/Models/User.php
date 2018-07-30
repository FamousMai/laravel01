<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
// Notifiable 是消息通知相关功能引用，Authenticatable 是授权相关功能的引用。
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        // creating 用于监听模型被创建之前的事件
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    // 获取头像
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    // 用户模型中，指明一个用户拥有多条微博。
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    // 获取当前用户关注的人发布过的所有微博动态
    public function feed()
    {
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids, Auth::user()->id);
        return Status::whereIn('user_id', $user_ids)
            ->with('user')
            ->orderBy('created_at', 'desc');
    }

    // 一个用户（粉丝）能够关注多个人，而被关注者能够拥有多个粉丝，像这种关系我们称之为「多对多关系」。在 Laravel 中我们使用 belongsToMany 来关联模型之间的多对多关系
    // 获取粉丝
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    // 获取关注
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    // 关注
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        // sync 方法会接收两个参数，第一个参数为要进行添加的 id，第二个参数则指明是否要移除其它不包含在关联的 id 数组中的 id，true 表示移除，false 表示不移除，默认值为 true。由于我们在关注一个新用户的时候，仍然要保持之前已关注用户的关注关系，因此不能对其进行移除，所以在这里我们选用 false
        $this->followings()->sync($user_ids, false);
    }

    // 取消关注
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    // 用于判断用户A是否关注了用户B
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
