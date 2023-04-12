<?php

namespace App;

/**
 * Eloquent class to describe the sessions table.
 *
 * automatically generated by ModelGenerator.php
 */
class Sessions extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'sessions';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'];
}
