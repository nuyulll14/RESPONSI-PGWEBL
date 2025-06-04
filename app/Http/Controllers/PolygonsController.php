<?php

namespace App\Http\Controllers;

use App\Models\PolygonsModel;
use App\Http\Controllers\PolygonsController;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    public function __construct()
    {
        $this->polygons = new PolygonsModel();

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:polygons,name',
            'description' => 'required',
            'geom_polygon' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        // Buat direktori jika belum ada
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777, true);
        }

        // Proses gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geom_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
            'user_id' => auth()->user()->id,
        ];

        if (!$this->polygons->create($data)) {
            return redirect()->route('map')->with('error', 'Polygon failed to be added');
        }

        return redirect()->route('map')->with('success', 'Polygon has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Polygon',
            'id' => $id,
        ];

        return view('edit-polygon', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation request
        $request->validate([
            'name' => 'required|unique:polygons,name,' . $id,
            'description' => 'required',
            'geom_polygon' => 'required',
            'image' => 'nullable|mimes:jpeg, png, jpg, gif, svg|max:1024',
        ],
        [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'description.required' => 'Description is required',
            'geom_polygon.required' => 'Geometry polygon is required',
        ]);

        // Create image directory if not exists
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get old image file name
        $old_image = $this->polygons->find($id)->image;

        // Get Image File
        if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
        $image->move('storage/images', $name_image);

        // Delete old image file
        if ($old_image != null) {
        if (file_exists('./storage/images/' . $old_image)) {
            unlink('./storage/images/' . $old_image); // Perbaikan di sini
        }
    }
    } else {
        $name_image = $old_image;
    }


        $data = [
            'geom' => $request->geom_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // Update data
        if (!$this->polygons->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Polygon failed to be updated');
        }

        // Redirect to map
        return redirect()->route('map')->with('success', 'Polygon has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = $this->polygons->find($id)->image;
        if (!$this->polygons->destroy($id)) {
            return redirect()->route('map')->with('error', 'Polygon failed to deleted!');
        }
        if ($image != null) {
            if (file_exists('./storage/images/' . $image)) {
                unlink('./storage/images/' . $image);
            }
        }
        return redirect()->route('map')->with('success', 'Polygon has been delete!');
    }
}
