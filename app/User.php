<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * User eloquent model.
 *
 * @author Erik Galloway <erik@fliplearning.com>
 */
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'gender'];
}
