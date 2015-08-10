<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 8/08/15
 * Time: 01:48 PM
 */

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}