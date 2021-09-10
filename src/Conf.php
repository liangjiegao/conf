<?php

namespace Yiyu\Conf;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conf extends Model
{
    use SoftDeletes;

    protected $table = 'conf';

    protected $primaryKey = 'conf_id';

    public  $incrementing = true;

    public $timestamps = true;

}
