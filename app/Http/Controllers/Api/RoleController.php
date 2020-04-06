<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function __construct()
    {
        $name = 'roles';
        $this->middleware('can:' . $name . '.create')->only('store');
        // Roles are not sensitive and that is needed for dropdown.
//        $this->middleware('can:' . $name . '.read')->only('index');
        $this->middleware('can:' . $name . '.read')->only('show');
        $this->middleware('can:' . $name . '.update')->only('update');
        $this->middleware('can:' . $name . '.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\DefaultResponse
     */
    public function index()
    {
        $roles = Role::query()->select(['id', 'name'])->get()->toArray();
        return new DefaultResponse([
            'status' => true,
            'message' => 'Roles list.',
            'data' => [
                'roles' => $roles
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
