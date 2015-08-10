<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 9/08/15
 * Time: 01:01 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contact_id', 'email', 'primary'];
}