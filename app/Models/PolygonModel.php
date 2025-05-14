<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PolygonModel extends Model
{
    protected $table = 'polygons';

    protected $guarded = ['id'];

    protected $fillable = [
        'geom',
        'name',
        'description',];
        public function geojson_polygon()
        {
            $polygon = $this->select(DB::raw('id, ST_AsGeoJSON(geom) as geom, name, description,
            st_area (geom, true) as luas_m2, st_area(geom, true)/1000000 as luas_km2, st_area(geom,true)/1000 as luas_hektar, created_at, updated_at')) ->get();

            $geojson = [
                'type' => 'FeatureCollection',
                'features' => [],
            ];

            foreach ($polygon as $p) {
                $feature = [
                    'type' => 'Feature',
                    'geometry' => json_decode($p->geom),
                    'properties' => [
                        'name' => $p->name,
                        'description' => $p->description,
                        'luas_m2' => $p->luas_m2,
                        'luas_km2' => $p->luas_km2,
                        'luas_hektar' =>$p->luas_hektar,
                        'created_at' => $p->created_at,
                        'updated_at' => $p->updated_at,
                    ],
                ];

                array_push($geojson['features'], $feature);
            }
            return[
                'type' => 'FeatureCollection',
            'features' => collect($polygons)->map(function ($polygon) {
                return [
                    'type' => 'Feature',
                    'geometry' => json_decode($polygon->geom),
                    'properties' => [
                        'name' => $polygon->name,
                        'description' => $polygon->description,
                        'image' => $polygon->image,
                        'area_m2' => $polygon->area_m2,
                        'area_ha' => $polygon->area_ha, // Konversi ke hektar
                        'created_at' => $polygon->created_at,
                        'updated_at' => $polygon->updated_at
                    ],
                ];
            })->toArray(),
        ];


        }
}
