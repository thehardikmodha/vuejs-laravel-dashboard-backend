<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private static $ITEM_PER_PAGE = 15;
    public function __construct()
    {
        $name = 'users';
        $this->middleware('can:' . $name . '.create')->only('store');
        $this->middleware('can:' . $name . '.read')->only('index');
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
        $userQuery = User::query()->with('roles');

        if (\request('role') != null)
        {
            $tempIds = User::role(\request('role'))->select(['users.id'])->get();
            $ids = [];
            foreach ($tempIds as $id) {
                $ids[] = $id->id;
            }
            $userQuery->whereIn('id', $ids);
        }

        if (\request('short_direction') == 'ace' || \request('short_direction') == 'desc')
        {
            $userQuery->orderBy('users.id', \request('short_direction'));
        }

        return new DefaultResponse([
            'status' => true,
            'message' => 'Users.',
            'data' => $userQuery->paginate(\request('perPage')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DefaultResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'roles' => 'required|array',
        ]);

        if ($validator->fails())
            return new DefaultResponse([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);

        $id = User::query()->where('email', '=', request('email'))->get()->toArray();

        if (isset($id[0]['id']))
        {
            $user = User::query()->find($id[0]['id']);
        }
        else
        {
            $user = new User();
            $user->name = request('name');
            $user->email = request('email');
            $user->phone = request('phone');
            $user->password = Hash::make('admin123');
            $user->save();
        }

        $user->syncRoles(request('roles'));

        return new DefaultResponse([
            'status' => true,
            'message' => 'Successfully Created User Account.',
        ]);
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
     * @return \App\Http\Resources\DefaultResponse
     */
    public function destroy($id)
    {
        try {
            User::query()->findOrFail($id)->delete();
            return new DefaultResponse([
                'status' => true,
                'message' => 'Successfully Deleted User Account.',
            ]);
        } catch (\Exception $e) {
            return new DefaultResponse([
                'status' => false,
                'message' => 'There was an error please try after sometime.',
            ]);
        }
    }
}
