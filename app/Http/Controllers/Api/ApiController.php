<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Models\Extracurricular;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *

     */
    public function index()
    {
        return response()->json(Extracurricular::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // This method is not typically used in RESTful APIs, as creation is usually handled by the store method.
        // If you need to return a view or form for creating a new resource, consider using a different controller or method.
        return response()->json(['message' => 'Use POST to create a new extracurricular']);
    }

    public function store(Request $request)
    {
        $extracurricular = Extracurricular::create($request->all());
        return response()->json($extracurricular, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $item = Extracurricular::find($id);
        if (!$item) {
            return response()->json(['message' => 'Not found'], 404);
        }
    return response()->json($item);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $extracurricular = Extracurricular::find($id);
        if (!$extracurricular) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $extracurricular->update($request->all());
        return response()->json($extracurricular);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $extracurricular = Extracurricular::find($id);
        if (!$extracurricular) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $extracurricular->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
