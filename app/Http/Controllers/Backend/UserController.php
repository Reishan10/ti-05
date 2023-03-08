<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $user = User::orderBy('name', 'asc')->get();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('type', function ($data) {
                    $type = $data->type;
                    if ($type === "superadmin") {
                        $name = "Superadmin";
                    } else {
                        $name = "Admin";
                    }
                    return $name;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-warning btn-sm me-1" data-id="' . $data->id . '" id="btnEdit"><i
                    class="mdi mdi-pencil"></i></button>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
                ->make(true);
        }
        return view('backend.user.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $email = $request->email;

        $validated = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
                'role' => ['required'],
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'email.required' => 'Silakan isi email terlebih dahulu!',
                'role.required' => 'Silakan isi role terlebih dahulu!',
                'email.unique' => 'Email sudah tersedia!',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $user = User::updateOrCreate([
                'id' => $id
            ], [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345'),
                'type' => $request->role,
            ]);
            return response()->json($user);
        }
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $users = User::where('id', $request->id)->delete();
        return Response()->json(['users' => $users, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $id = $request->id;
        User::whereIn('id', explode(",", $id))->delete();
        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
