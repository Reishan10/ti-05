<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $post = Post::with('kategori')->orderBy('date', 'desc')->get(['id', 'title', 'date', 'kategori_id', 'views']);
            return DataTables::of($post)
                ->addIndexColumn()
                ->addColumn('publish', function ($data) {
                    $tanggal = Carbon::parse($data->date);
                    $format_tanggal = $tanggal->format('d-m-Y');
                    return $format_tanggal;
                })
                ->addColumn('kategori', function ($data) {
                    $kategori = $data->kategori->name;
                    return $kategori;
                })
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<a href="' . route('post.edit', $data->id) . '" class="btn btn-warning btn-sm me-1"><i class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
                ->make(true);
        }
        return view('backend.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'kategori' => Kategori::orderBy('name', 'asc')->get(['id', 'name']),
            'tag' => Tag::orderBy('name', 'asc')->get(['id', 'name']),
        ];
        return view('backend.post.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'slug' => 'required',
                'content' => 'required',
                'image' => 'required|image|mimes:jpg,png,jpeg,webp,svg',
                'kategori' => 'required',
                'tag' => 'required|array',
                'tag.*' => 'required|string|distinct',
            ],
            [
                'title.required' => 'Silakan isi title terlebih dahulu!',
                'slug.required' => 'Silakan isi slug terlebih dahulu!',
                'content.required' => 'Silakan isi content terlebih dahulu!',
                'image.required' => 'Silakan isi image terlebih dahulu!',
                'image.image' => 'File harus berupa gambar!',
                'kategori.required' => 'Silakan isi kategori terlebih dahulu!',
                'tag.required' => 'Silakan isi tag terlebih dahulu!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $name = Str::slug($request->title);
            $guessExtension = $request->file('image')->guessExtension();
            $image_path = $request->file('image')->storeAs('images/posts', $name . '.' . $guessExtension, 'public');
            $row_tag[] = $request->tag;
            foreach ($row_tag as $tag) {
                $tags = @implode(",", $tag);
            }
            $data = [
                'title' => $request->title,
                'content' => $request->content,
                'image' => $image_path,
                'date' => date('Y-m-d') . " " . date('H:i:s'),
                'last_date' => date('Y-m-d') . " " . date('H:i:s'),
                'kategori_id' => $request->kategori,
                'tags' => $tags,
                'slug' => Str::slug($request->title),
                'status' => '1',
                'views' => 0,
                'user_id' => Auth::user()->id,
                'deskripsi' => $request->description
            ];

            $post = Post::create($data);

            return response()->json($post);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $kategori = Kategori::orderBy('name', 'asc')->get(['id', 'name']);
        $tag = Tag::orderBy('name', 'asc')->get(['id', 'name']);
        return view('backend.post.edit', compact('post', 'kategori', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'slug' => 'required',
                'content' => 'required',
                'image' => 'image|mimes:jpg,png,jpeg,webp,svg',
                'kategori' => 'required',
                'tag' => 'required|array',
                'tag.*' => 'required|string|distinct',
            ],
            [
                'title.required' => 'Silakan isi title terlebih dahulu!',
                'slug.required' => 'Silakan isi slug terlebih dahulu!',
                'content.required' => 'Silakan isi content terlebih dahulu!',
                'image.required' => 'Silakan isi image terlebih dahulu!',
                'image.image' => 'File harus berupa gambar!',
                'kategori.required' => 'Silakan isi kategori terlebih dahulu!',
                'tag.required' => 'Silakan isi tag terlebih dahulu!',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($file->isValid()) {
                    $name = Str::slug($request->title);

                    $post = Post::findOrFail($request->id);

                    if (Storage::exists($post->image)) {
                        Storage::delete($post->image);
                    }

                    $guessExtension = $file->guessExtension();
                    $image_path = $file->storeAs('images/posts', $name . '.' . $guessExtension, 'public');

                    $row_tag[] = $request->tag;
                    foreach ($row_tag as $tag) {
                        $tags = @implode(",", $tag);
                    }
                    $data = [
                        'title' => $request->title,
                        'content' => $request->content,
                        'image' => $image_path,
                        'last_date' => date('Y-m-d') . " " . date('H:i:s'),
                        'kategori_id' => $request->kategori,
                        'tags' => $tags,
                        'slug' => Str::slug($request->title),
                        'status' => '1',
                        'deskripsi' => $request->description
                    ];

                    $post = Post::where('id', $id)->update($data);

                    return response()->json($post);
                }
            } else {
                $name = Str::slug($request->title);
                $row_tag[] = $request->tag;
                foreach ($row_tag as $tag) {
                    $tags = @implode(",", $tag);
                }
                $data = [
                    'title' => $request->title,
                    'content' => $request->content,
                    'last_date' => date('Y-m-d') . " " . date('H:i:s'),
                    'kategori_id' => $request->kategori,
                    'tags' => $tags,
                    'slug' => Str::slug($request->title),
                    'status' => '1',
                    'deskripsi' => $request->description
                ];

                $post = Post::where('id', $id)->update($data);

                return response()->json($post);
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = Post::findOrFail($request->id);

        if (Storage::exists($post->image)) {
            Storage::delete($post->image);
            $post->delete();
        } else {
            $post->delete();
        }

        return Response()->json(['post' => $post, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $data = Post::whereIn('id', explode(",", $request->id))->get();

        foreach ($data as $row) {
            Storage::delete($row->image);
            $row->delete();
        }

        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
