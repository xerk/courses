<?php

namespace App\Models;

use Parental\HasParent;


class UserTrainer extends User
{
    use HasParent;
    protected $table = 'users';

}
