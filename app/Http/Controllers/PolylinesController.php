<?php

namespace App\Http\Controllers;

use App\Models\PolylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{

    public function __construct()
    {
        $this->polylines = new PolylinesModel();
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
        return view('polylines.create'); // Contoh view untuk form create
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate(
            [
                'name' => 'required|unique:polylines,name',
                'description' => 'required',
                'geom_polyline' => 'required',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exists',
                'description.required' => 'Description is required',
                'geom_polyline.required' => 'Geometry polylines is required',
            ]
        );

         //CREATE  IMAGE DIRECTOR IF NOT EXIST -PGWEBL 7
         if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        //GET IMAGE FILE - PGWEBL 7
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            //$image->storeAs('public/images', $name_image);

        } else {
            $name_image = null;
        }

        // Simpan data
        $data = [
            'geom' => $request->geom_polyline,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image
        ];

        // Buat data di database
        if (!$this->polylines->create($data)) {
            return redirect()->route('map')->with('error', 'Polyline could not be added');
        }

        // Redirect ke halaman peta dengan pesan sukses
        return redirect()->route('map')->with('success', 'Polyline has been added');
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
            'title' => 'Edit Polyline',
            'id' => $id,
        ];

        return view('edit_polyline', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = $this->polylines->find($id)->image;
        if (!$this->polylines->destroy($id)) {
            return redirect()->route('map')->with('error', 'Polyline failed to deleted!');
        }
        if ($image != null) {
            if (file_exists('./storage/images/' . $image)) {
                unlink('./storage/images/' . $image);
            }
            return redirect()->route('map')->with('success', 'Polyline has been delete!');
        }
        else {
            return redirect()->route('map')->with('success', 'Polyline has been delete!');
        }

    }
    
    }
