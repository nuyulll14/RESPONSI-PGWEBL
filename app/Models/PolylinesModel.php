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
        'user_id',
    ];

    // Menghasilkan seluruh polylines dalam format GeoJSON
    public function geojson_polylines()
    {
        $polylines = $this->select(
            'polylines.id',
            DB::raw('ST_AsGeoJSON(polylines.geom) as geom'),
            'polylines.name',
            'polylines.description',
            'polylines.image',
            DB::raw('ST_Length(polylines.geom, true) as length_m'),
            DB::raw('ST_Length(polylines.geom, true) / 1000 as length_km'),
            'polylines.created_at',
            'polylines.updated_at',
            'polylines.user_id',
            'users.name as user_created'
        )
        ->leftJoin('users', 'polylines.user_id', '=', 'users.id')
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
                    'length_m' => round((float) $p->length_m, 2),
                    'length_km' => round((float) $p->length_km, 2),
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'user_id' => $p->user_id,
                    'user_created' => $p->user_created,
                ],
            ];

            $geojson['features'][] = $feature;
        }

        return $geojson;
    }

    // Menghasilkan satu polyline berdasarkan ID dalam format GeoJSON
    public function geojson_polyline($id)
    {
        $polylines = $this->select(
            'id',
            DB::raw('ST_AsGeoJSON(geom) as geom'),
            'name',
            'description',
            'image',
            DB::raw('ST_Length(geom, true) as length_m'),
            DB::raw('ST_Length(geom, true)/1000 as length_km'),
            'created_at',
            'updated_at'
        )
        ->where('id', $id)
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
                    'length_m' => round((float) $p->length_m, 2),
                    'length_km' => round((float) $p->length_km, 2),
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                ],
            ];

            $geojson['features'][] = $feature;
        }

        return $geojson;
    }
}
