<?php

namespace App\Http\Controllers;

use App\Kasus;
use App\Fitur;
use App\DetailKasus;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        return view('kasus.index');
    }

    public function create()
    {
        return view('kasus.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_kasus' => "required|max:191",
                'solusi' => "required",
            ],
            [
                'nama_kasus.required' => 'Nama kasus harus diisi',
                'nama_kasus.max' => 'Nama kasus tidak boleh melebihi 191 karakter',
                'solusi.required' => 'Solusi harus diisi',
            ]
        );

        $kasus = Kasus::create($request->all());
        $nama_kasus = $request->get('nama_kasus');

        return view('kasus.detail.create1', [
            'kasus_id'=>$kasus->id,
            'type'=>null
        ]);
    }

    public function show($id)
    {
        $kasus = Kasus::findOrFail($id);
        $detail_kasus = DetailKasus::where('kasus_id', $id)->get();

        return view('kasus.view', [
            'kasus'=>$kasus,
            'detail_kasus'=>$detail_kasus
        ]);
    }

    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        return view('kasus.edit', [
            'kasus' => $kasus
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_kasus' => "required|max:191",
                'solusi' => "required",
            ],
            [
                'nama_kasus.required' => 'Nama kasus harus diisi',
                'nama_kasus.max' => 'Nama kasus tidak boleh melebihi 191 karakter',
                'solusi.required' => 'Solusi harus diisi',
            ]
        );

        $kasus = Kasus::findOrFail($id);
        $kasus->update($request->all());
        return redirect()->route('kasus.edit', ['kasus' => $id])->with('status', "Kasus \"$kasus->nama_kasus\" berhasil diedit");
    }

    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        $nama_kasus = $kasus->nama_kasus;
        $kasus->delete();
        return redirect()->route('kasus.index')->with('status', "Kasus $nama_kasus berhasil dihapus");
    }
}
