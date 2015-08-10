<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 10/08/15
 * Time: 12:19 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactImportLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['success', 'errors', 'extra_info', 'user_id'];
}