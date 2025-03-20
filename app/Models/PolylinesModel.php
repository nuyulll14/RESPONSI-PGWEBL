<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolylinesModel extends Model
{
    protected $table = 'polylines';

    protected $guarded = ['id'];

    public function geojson_polylines()
    {
        $polylines = DB::table($this->table)
            ->selectRaw('id, ST_AsGeoJSON(geom) as geom, name, description,
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
                    'name' => $p->name,
                    'description' => $p->description,
                    'length_m' => $p->length_m,
                    'length_km' => $p->length_km,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ],
            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }
}
