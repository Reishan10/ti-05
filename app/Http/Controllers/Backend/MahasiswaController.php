<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get(['nim', 'nama', 'tgl_lahir', 'no_telepon']);
            return DataTables::of($mahasiswa)
                ->addIndexColumn()
                ->addColumn('tgl_lahir', function ($data) {
                    $tanggal = Carbon::parse($data->tgl_lahir);
                    $format_tanggal = $tanggal->format('d-m-Y');
                    return $format_tanggal;
                })
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-nim='" . $data->nim . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-warning btn-sm me-1" data-nim="' . $data->nim . '" id="btnEdit"><i
                    class="mdi mdi-pencil"></i></button>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-nim="' . $data->nim . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
                ->make(true);
        }
        return view('backend.mahasiswa.index');
    }

    public function store(Request $request)
    {
        $nim = $request->nim;
        $validated = Validator::make(
            $request->all(),
            [
                'nim' => 'required|unique:mahasiswa,nim|min:9',
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'no_telepon' => 'required',
                'foto' => 'image|mimes:jpg,png,jpeg,webp,svg',
            ],
            [
                'nim.required' => 'Silakan isi NIM terlebih dahulu!',
                'nim.unique' => 'NIM Sudah digunakan!',
                'nim.min' => 'Minimal NIM 9 angka',
                'nama.required' => 'Silakan isi nama terlebih dahulu!',
                'jenis_kelamin.required' => 'Silakan pilih jenis kelamin terlebih dahulu!',
                'tempat_lahir.required' => 'Silakan isi tempat lahir terlebih dahulu!',
                'tgl_lahir.required' => 'Silakan isi tanggal lahir terlebih dahulu!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'foto.image' => 'File harus berupa gambar!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                if ($file->isValid()) {
                    $nim = $request->nim;
                    $nama = $request->nama;
                    $guessExtension = $request->file('foto')->guessExtension();
                    $foto_path = $request->file('foto')->storeAs('images/mahasiswa', $nim . ' - ' . $nama . '.' . $guessExtension, 'public');
                    $data = [
                        'nim' => $nim,
                        'nama' => $nama,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tgl_lahir' => $request->tgl_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'no_telepon' => $request->no_telepon,
                        'foto' => $foto_path,
                    ];
                    $mahasiswa = Mahasiswa::create($data);
                    return response()->json($mahasiswa);
                }
            } else {
                $nim = $request->nim;
                $nama = $request->nama;
                $data = [
                    'nim' => $nim,
                    'nama' => $nama,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'no_telepon' => $request->no_telepon,
                ];
                $mahasiswa = Mahasiswa::create($data);
                return response()->json($mahasiswa);
            }
        }
    }

    public function destroy(Request $request)
    {
        $mahasiswa = Mahasiswa::findOrFail($request->nim);
        if ($mahasiswa->foto != null) {
            Storage::delete($mahasiswa->foto);
            $mahasiswa->delete();
        } else {
            $mahasiswa->delete();
        }

        return Response()->json(['mahasiswa' => $mahasiswa, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $data = Mahasiswa::whereIn('nim', explode(",", $request->nim))->get();

        foreach ($data as $row) {
            if ($row->foto != null) {
                Storage::delete($row->foto);
                $row->delete();
            } else {
                $row->delete();
            }
        }

        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
