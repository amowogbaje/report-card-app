<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'role',
        'password',
        'othernames',
        'phone'
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
        'email_verified_at' => 'datetime',
    ];

    public  function student() {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->morphTo();
    }

    public function getFullNameAttribute()
    {
        return $this->firstname.' '.$this->middle_name.' '.$this->lastname;
    }

    public function getDobMonthDayAttribute() 
    {
        
            // return  $this->dob;
            return date('M d', strtotime($this->dob));
    }

    public function getAgeAttribute() 
    {
        // return 14;
        $currentDate = strtotime(new Carbon());
        $dob = strtotime($this->dob);
        $yearString = $currentDate - $dob;
        // return $yearString;
        // $year = date('Y', $yearString);
        $year = floor($yearString/(60*60*24*365));
        return $year;
        

    }

    
}
