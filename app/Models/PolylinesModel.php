<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolylinesModel extends Model
{
    protected $table = 'polylines';

    protected $guarded = ['id'];
    public $timestamps = true;

    public function geojson_polylines()
    {
        $polylines = DB::table($this->table)
            ->selectRaw('id, ST_AsGeoJSON(geom) as geom, name, description,
            ST_Length(geography(geom)) as length_m,
            ST_Length(geography(geom)) / 1000 as length_km,
            created_at, updated_at')
            ->get();


            return [
                'type' => 'FeatureCollection',
                'features' => collect($polylines)->map(function ($polyline) {
                    return [
                        'type' => 'Feature',
                        'geometry' => json_decode($polyline->geom),
                        'properties' => [
                            'name' => $polyline->name,
                            'description' => $polyline->description,
                            'image' => $polyline->image,
                            'length_km' => round((float) $polyline->length_km, 2),
                            'length_km' => (float) $polyline->length_km,
                            'created_at' => $polyline->created_at,
                            'updated_at' => $polyline->updated_at
                        ],
                    ];
                })->toArray(),
            ];
        }

        protected $fillable = [
            'geom',
            'name',
            'description',
            'image',
        ];
}
