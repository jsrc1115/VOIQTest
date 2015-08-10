<?php

namespace App\ValueObjects;

class CRUDResultData
{
    public $success = false;
    public $errors = null;
    public $extra_info = '';
}