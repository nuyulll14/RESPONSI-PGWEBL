<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PolygonsModel extends Model
{


    protected $table = 'polygons';

    protected $guarded = ['id'];

    protected $fillable = [
        'geom',
        'name',
        'description',
    ];
}
