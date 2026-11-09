<?php

namespace App\Http\Controllers;

use App\Models\M_Dosen;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class C_Dosen extends Controller
{
    private M_Dosen $M_Dosen;

    public function __construct()
    {
        $this->M_Dosen = new M_Dosen();
    }

    public function index(): View
    {
        return view('v_dosen', [
            'dosen' => $this->M_Dosen->allData(),
        ]);
    }

    public function detail(string $id_dosen): View
    {
        $dosen = $this->M_Dosen->detailData($id_dosen);
        if (! $dosen) {
            abort(404);
        }

        return view('v_detaildosen', [
            'dosen' => $dosen,
        ]);
    }

    public function add(): View
    {
        return view('v_adddosen', [
            'nextId' => $this->M_Dosen->generateId(),
        ]);
    }

    public function insert(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => ['required', 'string', 'min:17', 'max:18', 'regex:/^[0-9]+$/', 'unique:tb_dosen,nip'],
            'nama_dosen' => ['required', 'string', 'max:200'],
            'mata_kuliah' => ['required', 'string', 'max:200'],
            'foto_dosen' => ['required', 'file', 'mimes:jpg,jpeg,png,bmp,webp', 'max:1024'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP ini sudah terdaftar di database.',
            'nip.min' => 'NIP minimal 17 digit.',
            'nip.max' => 'NIP maksimal 18 digit.',
            'nip.regex' => 'NIP hanya boleh berisi angka.',
            'nama_dosen.required' => 'Nama Dosen wajib diisi.',
            'mata_kuliah.required' => 'Mata Kuliah wajib diisi.',
            'foto_dosen.required' => 'Foto Dosen wajib diunggah.',
            'foto_dosen.mimes' => 'Foto harus berformat jpg, jpeg, png, bmp, atau webp.',
            'foto_dosen.max' => 'Ukuran foto maksimal 1 MB.',
        ]);

        $file = $request->file('foto_dosen');
        $uploadDir = public_path('foto_dosen');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate ID inside transaction so concurrent inserts do not collide on PEGxxxx.
        $idDosen = DB::transaction(function () use ($validated, $file, $uploadDir): string {
            $id = $this->M_Dosen->generateId();
            $fileName = $id.'.'.$file->extension();
            $file->move($uploadDir, $fileName);

            $this->M_Dosen->addData([
                'id_dosen' => $id,
                'nip' => $validated['nip'],
                'nama_dosen' => $validated['nama_dosen'],
                'mata_kuliah' => $validated['mata_kuliah'],
                'foto_dosen' => $fileName,
            ]);

            return $id;
        });

        return redirect()->route('dosen')->with('pesan', "Data dosen {$idDosen} berhasil ditambahkan.");
    }

    public function edit(string $id_dosen): View
    {
        $dosen = $this->M_Dosen->detailData($id_dosen);
        if (! $dosen) {
            abort(404);
        }

        return view('v_editdosen', [
            'dosen' => $dosen,
        ]);
    }

    public function update(Request $request, string $id_dosen): RedirectResponse
    {
        $dosen = $this->M_Dosen->detailData($id_dosen);
        if (! $dosen) {
            abort(404);
        }

        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'min:17',
                'max:18',
                'regex:/^[0-9]+$/',
                Rule::unique('tb_dosen', 'nip')->ignore($id_dosen, 'id_dosen'),
            ],
            'nama_dosen' => ['required', 'string', 'max:200'],
            'mata_kuliah' => ['required', 'string', 'max:200'],
            'foto_dosen' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,webp', 'max:1024'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP ini sudah terdaftar pada dosen lain.',
            'nip.min' => 'NIP minimal 17 digit.',
            'nip.max' => 'NIP maksimal 18 digit.',
            'nip.regex' => 'NIP hanya boleh berisi angka.',
            'nama_dosen.required' => 'Nama Dosen wajib diisi.',
            'mata_kuliah.required' => 'Mata Kuliah wajib diisi.',
            'foto_dosen.mimes' => 'Foto harus berformat jpg, jpeg, png, bmp, atau webp.',
            'foto_dosen.max' => 'Ukuran foto maksimal 1 MB.',
        ]);

        $payload = [
            'nip' => $validated['nip'],
            'nama_dosen' => $validated['nama_dosen'],
            'mata_kuliah' => $validated['mata_kuliah'],
        ];

        if ($request->hasFile('foto_dosen')) {
            $uploadDir = public_path('foto_dosen');
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $oldPath = $uploadDir.DIRECTORY_SEPARATOR.basename((string) $dosen->foto_dosen);
            if ($dosen->foto_dosen && is_file($oldPath)) {
                @unlink($oldPath);
            }

            $file = $request->file('foto_dosen');
            $fileName = $id_dosen.'_'.time().'.'.$file->extension();
            $file->move($uploadDir, $fileName);
            $payload['foto_dosen'] = $fileName;
        }

        $this->M_Dosen->editData($id_dosen, $payload);

        return redirect()->route('dosen')->with('pesan', "Data dosen {$id_dosen} berhasil diperbarui.");
    }

    public function delete(string $id_dosen): RedirectResponse
    {
        $dosen = $this->M_Dosen->detailData($id_dosen);
        if (! $dosen) {
            abort(404);
        }

        if ($dosen->foto_dosen) {
            $photoPath = public_path('foto_dosen').DIRECTORY_SEPARATOR.basename((string) $dosen->foto_dosen);
            if (is_file($photoPath)) {
                @unlink($photoPath);
            }
        }

        $this->M_Dosen->deleteData($id_dosen);

        return redirect()->route('dosen')->with('pesan', "Data dosen {$id_dosen} berhasil dihapus.");
    }

    public function print(): Response
    {
        $html = view('v_printdosen', [
            'dosen' => $this->M_Dosen->allData(),
            'printedAt' => now()->format('d M Y'),
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-data-dosen.pdf"',
        ]);
    }
}
