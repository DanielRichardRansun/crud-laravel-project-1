<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //menampilkan semua data
    {
        //untuk fungsi search
        $jumlahbaris = 5;
        $katakunci = $request->katakunci;
        if (strlen($katakunci)) {
            // mengambil data apakah dari nim,nama, dan jurusan
            $data = mahasiswa::where("nim", "like", "%" . $katakunci . "%")
                ->orWhere("nama", "like", "%" . $katakunci . "%")
                ->orWhere("jurusan", "like", "%" . $katakunci . "%")
                ->paginate($jumlahbaris);
        } else {
            //mengambil data untuk ditampilkan di index
            $data = mahasiswa::orderBy("nim", "desc")->paginate($jumlahbaris);
        }
        //mengakses/menampilkan resources/views/mahasiswa/index.blade.php
        return view("mahasiswa.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // menampilkan form add data baru
    {
        return view("mahasiswa.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //digunakan memasukan data baru ke database
    {
        //proses validasi
        //import vacades terlebih dahulu, agar data tidak hilang saat error, dipanggil dicreate terlebih dahulu {{ Session::get('nim')}}
        Session::flash("nim", $request->nim);
        Session::flash("nama", $request->nama);
        Session::flash("jurusan", $request->jurusan);

        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim',
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'nim.numeric' => 'NIM wajib diisi dalam angka',
            'nim.unique' => 'NIM sudah terpakai',
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ]);
        //masukan sesuai name="" pada blase
        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ];
        //masukan ke tabel mahasiswa
        mahasiswa::create($data);

        //mengarahkan ke halaman depan dan mengasih pesan berhasil input data, dan dipanggil di tamplate.blade.php
        return redirect()->to('mahasiswa')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) //menampilkan detail data
    {
        //DILAKUKAN PADA FUNGSI INDEX
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) //menampilkan form untuk edit
    {
        $data = mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) //menyimpan update data kita
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'nim.unique' => 'NIM sudah terpakai',
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ]);
        //masukan sesuai name="" pada blase
        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ];
        //masukan ke tabel mahasiswa
        mahasiswa::where('nim', $id)->update($data);

        //mengarahkan ke halaman depan dan mengasih pesan berhasil input data, dan dipanggil di tamplate.blade.php
        return redirect()->to('mahasiswa')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //penghapusan data
    {
        //menghapus data
        mahasiswa::where('nim', $id)->delete();
        //mengarahkan ke halaman depan dan mengasih pesan berhasil input data, dan dipanggil di tamplate.blade.php
        return redirect()->to('mahasiswa')->with('success', 'Berhasil delete data');
    }
}
