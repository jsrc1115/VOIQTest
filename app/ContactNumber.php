<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 9/08/15
 * Time: 04:02 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactNumber extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contact_id', 'phone_number'];
}