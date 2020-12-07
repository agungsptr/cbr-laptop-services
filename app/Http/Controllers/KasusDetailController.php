<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fitur;
use App\Kasus;
use App\DetailKasus;

class KasusDetailController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function create($id)
    {
        $kasus = Kasus::findOrFail($id);
        return view('kasus.detail.create1', [
            'kasus_id'=>$id,
            'type'=>'add'
        ]);
    }
    
    public function store1(Request $request)
    {
        $request->validate(
            [
                'kasus_id' => "required",
                'checks' => "required",
            ],
            [
                'kasus.required' => 'ID kasus harus ada',
                'checks.required' => 'Fitur harus dipilih minimal 1',
            ]
        );
        $type = $request->get('type');

        $kasus_id = $request->get('kasus_id');
        $kasus = Kasus::findOrFail($kasus_id);

        $checks = $request->input('checks');

        $fiturs = [];
        foreach ($checks as $check => $value) {
            $fitur = Fitur::findOrFail($value);
            array_push($fiturs, $fitur);
        }

        return view('kasus.detail.create2', [
            'fiturs' => $fiturs,
            'kasus_id' => $kasus_id,
            'type'=>$type
        ]);
    }

    public function store2(Request $request)
    {
        $request->validate(
            [
                'kasus_id' => "required",
                'fiturs' => "required",
                'bobots' => "required",
            ],
            [
                'kasus.required' => 'ID kasus harus ada',
                'fiturs.required' => 'Fiturs harus ada minimal 1',
                'bobots.required' => 'Bobots harus ada minimal 1',
            ]
        );
        $type = $request->get('type');

        $kasus_id = $request->get('kasus_id');
        $kasus = Kasus::findOrFail($kasus_id);

        $fiturs = $request->input('fiturs');
        $bobots = $request->input('bobots');

        for ($i=0; $i < count($fiturs); $i++) {
            $fitur = Fitur::findOrFail($fiturs[$i]);

            $dk = new DetailKasus;
            $dk->kasus_id = $kasus_id;
            $dk->fitur_id = $fiturs[$i];
            $dk->bobot = $bobots[$i];
            $dk->save();
        }

        if ($type == 'add') {
            return redirect()->route('kasus.show', ['kasus'=>$kasus_id])->with('status', "Fitur berhasil ditambah");
        } else {
            return redirect()->route('kasus.create')->with('status', "Kasus \"$kasus->nama_kasus\" berhasil ditambah");
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $dk = DetailKasus::findOrFail($id);
        $dk->bobot = $request->get('bobot');
        $dk->save();
        return redirect()->route('kasus.show', ['kasus'=>$dk->kasus_id])->with('status', "Bobot berhasil diedit");
    }

    public function destroy($id)
    {
        $dk = DetailKasus::findOrFail($id);
        $fitur = $dk->Fitur()->nama_fitur;
        $kasus_id = $dk->kasus_id;
        $dk->delete();

        return redirect()->route('kasus.show', ['kasus'=>$kasus_id])->with('status', "Fitur $fitur berhasil dihapus");
    }
}
