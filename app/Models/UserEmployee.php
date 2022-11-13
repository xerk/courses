<?php

namespace App\Models;

use Parental\HasParent;

class UserEmployee extends User
{
    use HasParent;
    protected $table = 'users';

}
