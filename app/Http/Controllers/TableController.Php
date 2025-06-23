<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\PolygonsModel;
use App\Models\PolylinesModel;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct()
    {
        $this->points = new PointsModel();
        $this->polylines = new PolylinesModel();
        $this->polygons = new PolygonsModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Table',
        'points' => $this->points->paginate(10, ['*'], 'pointsPage'),
        'polylines' => $this->polylines->paginate(10, ['*'], 'polylinesPage'),
        'polygons' => $this->polygons->paginate(10, ['*'], 'polygonsPage'),
        ];

        return view('table',$data);
    }
}
