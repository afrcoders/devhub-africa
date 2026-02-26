<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StudyGroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_group_id',
        'user_id',
        'role',
    ];

    public function studyGroup()
    {
        return $this->belongsTo(StudyGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
