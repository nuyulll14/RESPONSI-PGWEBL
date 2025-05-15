<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolylinesModel extends Model
{
    protected $table = 'polylines';

    protected $guarded = ['id'];

    protected $fillable = [
        'geom',
        'name',
        'description',
        'image',
    ];

    public function geojson_polylines()
    {
        $polylines = DB::table($this->table)
            ->selectRaw('id, ST_AsGeoJSON(geom) as geom, name, description, image,
            ST_Length(geography(geom)) as length_m,
            ST_Length(geography(geom)) / 1000 as length_km,
            created_at, updated_at')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polylines as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                            'id' => $p->id,
                            'name' => $p->name,
                            'description' => $p->description,
                            'image' => $p->image,
                            'length_km' => round((float) $p->length_km, 2),
                            'length_km' => (float) $p->length_km,
                            'created_at' => $p->created_at,
                            'updated_at' => $p->updated_at
                        ],
                    ];
                    array_push($geojson['features'], $feature);
        }
        return $geojson;
    }
}
