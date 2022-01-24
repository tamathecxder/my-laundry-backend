<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Http\Requests\StoreOutletRequest;
use App\Http\Requests\UpdateOutletRequest;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('outlet.index', [
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
     * @param  \App\Http\Requests\StoreOutletRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required|min:6|max:600',
            'tlp' => 'required|numeric',
        ]);

        $inputOutlet = Outlet::create($validate);

        if ($inputOutlet) return redirect('outlet')->with('success', 'Data outlet telah berhasil ditambahkan');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show(Outlet $outlet)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function edit(Outlet $outlet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOutletRequest  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $outlet = Outlet::findOrFail($id);
        $rules = $request->validate([
            'nama' => 'required',
            'alamat' => 'required|min:6|max:600',
            'tlp' => 'required|numeric',
        ]);

        $update = $outlet->find($id)->update($rules);

        if ($update) return redirect('outlet')->with('success', 'Data outlet sukses di-update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapusOutlet = Outlet::findOrFail($id);

        $hapusOutlet->find($id)->delete();

        if ( $hapusOutlet ) {
            return redirect('outlet')->with('success', 'Data outlet telah berhasil dihapus');
        } else {
            return redirect('outlet')->with('failed', 'Data outlet gagal dihapus');
        }
    }
}
