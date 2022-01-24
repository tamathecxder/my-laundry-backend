<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Http\Requests\StorePaketRequest;
use App\Http\Requests\UpdatePaketRequest;
use App\Models\Outlet;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paket.index', [
            'paket' => Paket::all(),
            'outlet' => Outlet::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'id_outlet' => 'required',
            'harga' => 'required',
            'nama_paket' => 'required',
            'jenis' => 'required',
        ]);

        $paket = Paket::create($validasiData);

        if ( $paket ) {
            return redirect('paket')->with('success', 'Data paket telah ditambahkan');
        } else {
            return redirect('paket')->with('failed', 'Data gagal diinputkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Paket $paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaketRequest  $request
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $rules = $request->validate([
            'id_outlet' => 'required',
            'harga' => 'required',
            'nama_paket' => 'required',
            'jenis' => 'required|string'
        ]);

        $update = $paket->find($id)->update($rules);

        if ( $update ) {
            return redirect('paket')->with('success', 'Data paket telah berhasil di-update');
        } else {
            return redirect('paket')->with('error', 'Data paket gagal di-update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);

        $paket->find($id)->delete();

        if ( $paket ) {
            return redirect('paket')->with('success', 'Data paket telah terhapus');
        } else {
            return redirect('paket')->with('error', 'Data paket gagal dihapus');
        }
    }
}
