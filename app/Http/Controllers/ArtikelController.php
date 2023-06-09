<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['artikel'] = Artikel::orderByDesc('id')->get();
        return view("admin.article.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.article.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'judul' => 'required',
            'deskripsi' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        $reqImage = $request->image;
        if ($request->hasFile('image')) {
            $name = time() . rand(1, 100) . '.' . $reqImage->extension();
            $reqImage->move(public_path() . '/upload/artikel/', $name);
            $imageurl = $name;
        }

        $dtarticles = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $imageurl,
            'status' => $request->status,
            'created_at' => now(),
        ];

        $save = DB::table('artikels')->insert($dtarticles);

        if ($save) {
            return redirect('/artikel')
                ->with([
                    'success' => 'Data Berhasil Ditambah',
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Data Gagal Ditambah!',
                ]);
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
        $data['articles'] = Artikel::where('id',$id)->first();
        return view('admin.article.edit', $data);
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
        $articles =  DB::table('artikels')->where('id', $id)->first();
        $imageurl = $articles->image;

        if ($request->hasFile('image')) {
            $reqImage = $request->image;
            $name = time() . rand(1, 100) . '.' . $reqImage->extension();
            $reqImage->move(public_path() . '/upload/artikel/', $name);
            $imageurl = $name;

            $file = 'upload/artikel/' . $articles->image;
            if ($articles->image != '' && $articles->image != null) {
                unlink($file);
            }
        }

        $dtarticles = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $imageurl,
            'status' => $request->status,
            'updated_at' => now(),
        ];

        $data = DB::table('artikels')
            ->where('id', $id)
            ->update($dtarticles);

        if ($data) {
            return redirect('/artikel')
                ->with([
                    'success' => 'Data Berhasil Diperbarui',
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Data Gagal Diperbarui!',
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articles = Artikel::where('id', $id)->first();

        if (empty($articles)) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'data Artikel tidak ditemukan!',
                ]);
        }

        $file = 'upload/artikel/' . $articles->image;
        if ($articles->image != '' && $articles->image != null) {
            unlink($file);
        }

        $data = Artikel::where('id', $id)->delete();

        if ($data) {
            return redirect('/artikel')
                ->with([
                    'success' => 'Data Berhasil Dihapus',
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Data Gagal Dihapus!',
                ]);
        }
    }
}