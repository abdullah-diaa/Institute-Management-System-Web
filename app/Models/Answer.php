<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'user_id',
        'file_path',
        'uploaded_at', // If you include the date and time of upload
    ];
     
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];
    // Define the relationship with the Assignment model
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
