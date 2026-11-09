<?php

namespace App\Http\Controllers;

use App\Models\M_Mahasiswa;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class C_Mahasiswa extends Controller
{
    private M_Mahasiswa $M_Mahasiswa;

    public function __construct()
    {
        $this->M_Mahasiswa = new M_Mahasiswa();
    }

    public function index(): View
    {
        return view('v_mahasiswa', [
            'mahasiswa' => $this->M_Mahasiswa->allData(),
        ]);
    }

    public function detail(string $nim): View
    {
        $mahasiswa = $this->M_Mahasiswa->detailData($nim);
        if (! $mahasiswa) {
            abort(404);
        }

        return view('v_detailmahasiswa', [
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function add(): View
    {
        return view('v_addmahasiswa', [
            'suggestedNim' => $this->M_Mahasiswa->suggestNim(),
        ]);
    }

    public function insert(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9]+$/', 'unique:tb_mahasiswa,nim'],
            'nama' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:100'],
            'prodi' => ['required', 'string', 'max:100'],
            'ttl' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'agama' => ['required', 'string', 'max:100'],
            'tingkat' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'nomor_handphone' => ['required', 'string', 'min:9', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'foto_mahasiswa' => ['required', 'file', 'mimes:jpg,jpeg,png,bmp,webp', 'max:1024'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM ini sudah terdaftar di database.',
            'nim.regex' => 'NIM hanya boleh berisi huruf atau angka tanpa spasi.',
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'prodi.required' => 'Program Studi wajib diisi.',
            'ttl.required' => 'Tempat, Tanggal Lahir wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'tingkat.required' => 'Tingkat wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'nomor_handphone.required' => 'Nomor handphone wajib diisi.',
            'nomor_handphone.regex' => 'Format nomor handphone tidak valid.',
            'foto_mahasiswa.required' => 'Foto mahasiswa wajib diunggah.',
            'foto_mahasiswa.mimes' => 'Foto harus berformat jpg, jpeg, png, bmp, atau webp.',
            'foto_mahasiswa.max' => 'Ukuran foto maksimal 1 MB.',
        ]);

        $uploadDir = public_path('foto_mahasiswa');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file = $request->file('foto_mahasiswa');
        $fileName = $validated['nim'].'.'.$file->extension();
        $file->move($uploadDir, $fileName);

        $this->M_Mahasiswa->addData([
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'jurusan' => $validated['jurusan'],
            'prodi' => $validated['prodi'],
            'ttl' => $validated['ttl'],
            'alamat' => $validated['alamat'],
            'agama' => $validated['agama'],
            'tingkat' => (int) $validated['tingkat'],
            'semester' => (int) $validated['semester'],
            'nomor_handphone' => $validated['nomor_handphone'],
            'foto_mahasiswa' => $fileName,
        ]);

        return redirect()->route('mahasiswa')->with('pesan', "Data mahasiswa {$validated['nim']} berhasil ditambahkan.");
    }

    public function edit(string $nim): View
    {
        $mahasiswa = $this->M_Mahasiswa->detailData($nim);
        if (! $mahasiswa) {
            abort(404);
        }

        return view('v_editmahasiswa', [
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function update(Request $request, string $nim): RedirectResponse
    {
        $mahasiswa = $this->M_Mahasiswa->detailData($nim);
        if (! $mahasiswa) {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:100'],
            'prodi' => ['required', 'string', 'max:100'],
            'ttl' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'agama' => ['required', 'string', 'max:100'],
            'tingkat' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'nomor_handphone' => ['required', 'string', 'min:9', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'foto_mahasiswa' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,webp', 'max:1024'],
        ], [
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'prodi.required' => 'Program Studi wajib diisi.',
            'ttl.required' => 'Tempat, Tanggal Lahir wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'tingkat.required' => 'Tingkat wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'nomor_handphone.required' => 'Nomor handphone wajib diisi.',
            'nomor_handphone.regex' => 'Format nomor handphone tidak valid.',
            'foto_mahasiswa.mimes' => 'Foto harus berformat jpg, jpeg, png, bmp, atau webp.',
            'foto_mahasiswa.max' => 'Ukuran foto maksimal 1 MB.',
        ]);

        $payload = [
            'nama' => $validated['nama'],
            'jurusan' => $validated['jurusan'],
            'prodi' => $validated['prodi'],
            'ttl' => $validated['ttl'],
            'alamat' => $validated['alamat'],
            'agama' => $validated['agama'],
            'tingkat' => (int) $validated['tingkat'],
            'semester' => (int) $validated['semester'],
            'nomor_handphone' => $validated['nomor_handphone'],
        ];

        if ($request->hasFile('foto_mahasiswa')) {
            $uploadDir = public_path('foto_mahasiswa');
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $oldPath = $uploadDir.DIRECTORY_SEPARATOR.basename((string) $mahasiswa->foto_mahasiswa);
            if ($mahasiswa->foto_mahasiswa && is_file($oldPath)) {
                @unlink($oldPath);
            }

            $file = $request->file('foto_mahasiswa');
            $fileName = $nim.'_'.time().'.'.$file->extension();
            $file->move($uploadDir, $fileName);
            $payload['foto_mahasiswa'] = $fileName;
        }

        $this->M_Mahasiswa->editData($nim, $payload);

        return redirect()->route('mahasiswa')->with('pesan', "Data mahasiswa {$nim} berhasil diperbarui.");
    }

    public function delete(string $nim): RedirectResponse
    {
        $mahasiswa = $this->M_Mahasiswa->detailData($nim);
        if (! $mahasiswa) {
            abort(404);
        }

        if ($mahasiswa->foto_mahasiswa) {
            $photoPath = public_path('foto_mahasiswa').DIRECTORY_SEPARATOR.basename((string) $mahasiswa->foto_mahasiswa);
            if (is_file($photoPath)) {
                @unlink($photoPath);
            }
        }

        $this->M_Mahasiswa->deleteData($nim);

        return redirect()->route('mahasiswa')->with('pesan', "Data mahasiswa {$nim} berhasil dihapus.");
    }

    public function print(): Response
    {
        $html = view('v_printmahasiswa', [
            'mahasiswa' => $this->M_Mahasiswa->allData(),
            'printedAt' => now()->format('d M Y'),
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-data-mahasiswa.pdf"',
        ]);
    }
}
