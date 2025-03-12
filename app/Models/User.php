<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name_update',
        'email',
        'password',
        'gender',
        'role',
        'status',
        'member' ,
    ];

  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' , 'last_name_update' => 'datetime',
        
    ];
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
    // public function enrollments()
    // {
    //     return $this->hasMany(Enrollment::class);
    // }
    // public function authoredCourses()
    // {
    //     return $this->hasMany(Course::class, 'author_id');
    // }
    
  public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    // Define the relationship with the Course model for the published courses
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')
                    ->withTimestamps();
    }
    
}
