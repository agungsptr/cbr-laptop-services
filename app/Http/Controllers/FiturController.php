<?php

namespace App\Http\Controllers;

use App\Fitur;
use Illuminate\Http\Request;

class FiturController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function index()
    {
        return view('fitur.index');
    }

    public function create()
    {
        return view('fitur.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_fitur' => "required",
            ],
            [
                'nama_fitur.required' => 'Fitur harus diisi',
            ]
        );

        $fitur = Fitur::create($request->all());
        return redirect()->route('fitur.create')->with('status', "Fitur berhasil ditambahkan");
    }

    public function edit($id)
    {
        $fitur = Fitur::findOrFail($id);
        return view('fitur.edit', [
            'fitur' => $fitur
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_fitur' => "required",
            ],
            [
                'nama_fitur.required' => 'Fitur harus diisi',
            ]
        );

        $fitur = Fitur::findOrFail($id);
        $fitur->update($request->all());
        return redirect()->route('fitur.edit', ['fitur' => $id])->with('status', "Fitur berhasil diedit");
    }

    public function destroy($id)
    {
        $fitur = Fitur::findOrFail($id);
        $fitur->delete();
        return redirect()->route('fitur.index')->with('status', "Fitur berhasil dihapus");
    }
}
