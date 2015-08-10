<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 9/08/15
 * Time: 12:57 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'user_id'];

    public function emails()
    {
        return $this->hasMany('App\ContactEmail');
    }

    public function phoneNumbers()
    {
        return $this->hasMany('App\ContactNumber');
    }
}