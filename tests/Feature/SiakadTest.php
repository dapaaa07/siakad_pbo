<?php

namespace Tests\Feature;

use App\Models\M_Dosen;
use App\Models\User;
use Database\Seeders\SiakadSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiakadTest extends TestCase
{
    use RefreshDatabase;

    /** @var array<int, string> */
    private array $createdFiles = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SiakadSeeder::class);
    }

    protected function tearDown(): void
    {
        foreach ($this->createdFiles as $path) {
            if (is_file($path)) {
                @unlink($path);
            }
        }
        parent::tearDown();
    }

    private function createFakeImageBytes(): string
    {
        // Minimal valid 1x1 PNG so UploadedFile::fake()->image() works without requiring GD.
        return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
    }

    private function fakePhoto(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, $this->createFakeImageBytes());
    }

    public function test_guest_is_redirected_to_login_from_protected_routes(): void
    {
        foreach (['/home', '/dosen', '/mahasiswa', '/user', '/about', '/chart', '/invoice'] as $uri) {
            $this->get($uri)->assertRedirect(route('login'));
        }
    }

    public function test_login_and_logout_across_all_four_role_levels(): void
    {
        $cases = [
            ['email' => 'admin@siakad.test', 'redirect' => '/home'],
            ['email' => 'user@siakad.test', 'redirect' => '/user'],
            ['email' => 'mahasiswa@siakad.test', 'redirect' => '/mahasiswa'],
            ['email' => 'dosen@siakad.test', 'redirect' => '/dosen'],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('login.post'), [
                'email' => $case['email'],
                'password' => 'password',
            ]);
            $response->assertRedirect($case['redirect']);
            $this->assertAuthenticated();

            $this->post(route('logout'))->assertRedirect(route('login'));
            $this->assertGuest();
        }

        $badLogin = $this->post(route('login.post'), [
            'email' => 'admin@siakad.test',
            'password' => 'wrong-password',
        ]);
        $badLogin->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_register_creates_user_with_selected_level_and_allows_login(): void
    {
        $this->get(route('register'))->assertOk()->assertSee('Registrasi Akun SIAKAD');

        $response = $this->post(route('register.proses'), [
            'name' => 'Rina Kurniawati',
            'email' => 'rina@siakad.test',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'level' => '3',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'rina@siakad.test',
            'level' => 3,
        ]);

        $this->post(route('login.post'), [
            'email' => 'rina@siakad.test',
            'password' => 'rahasia123',
        ])->assertRedirect('/mahasiswa');
    }

    public function test_role_middlewares_enforce_403_access_boundaries(): void
    {
        $user = User::where('email', 'user@siakad.test')->firstOrFail();
        $this->actingAs($user);
        $this->get('/home')->assertOk();
        $this->get('/user')->assertOk();
        $this->get('/dosen')->assertForbidden();
        $this->get('/mahasiswa')->assertForbidden();
        $this->get('/about')->assertForbidden();
        $this->get('/chart')->assertForbidden();
        $this->get('/invoice')->assertForbidden();

        $mahasiswa = User::where('email', 'mahasiswa@siakad.test')->firstOrFail();
        $this->actingAs($mahasiswa);
        $this->get('/home')->assertOk();
        $this->get('/mahasiswa')->assertOk();
        $this->get('/dosen')->assertForbidden();
        $this->get('/user')->assertForbidden();
        $this->get('/about')->assertForbidden();

        $dosen = User::where('email', 'dosen@siakad.test')->firstOrFail();
        $this->actingAs($dosen);
        $this->get('/home')->assertOk();
        $this->get('/dosen')->assertOk();
        $this->get('/mahasiswa')->assertForbidden();
        $this->get('/user')->assertForbidden();
        $this->get('/chart')->assertForbidden();
    }

    public function test_dosen_crud_auto_id_detail_and_pdf_export(): void
    {
        $admin = User::where('email', 'admin@siakad.test')->firstOrFail();
        $this->actingAs($admin);

        $this->get('/dosen')
            ->assertOk()
            ->assertSee('PEG0001')
            ->assertSee('Mohammad Iqbal, S.Kom., M.T.');

        $this->get('/dosen/detail/PEG0001')
            ->assertOk()
            ->assertSee('199001262019031025')
            ->assertSee('Pemrograman Berorientasi Objek');

        $this->get('/dosen/add')
            ->assertOk()
            ->assertSee('value="PEG0004"', false);

        $insertResponse = $this->post('/dosen/insert', [
            'nip' => '199205142020121009',
            'nama_dosen' => 'Budi Santoso, M.Kom.',
            'mata_kuliah' => 'Jaringan Komputer',
            'foto_dosen' => $this->fakePhoto('budi.png'),
        ]);
        $insertResponse->assertRedirect('/dosen');

        $inserted = DB::table('tb_dosen')->where('id_dosen', 'PEG0004')->first();
        $this->assertNotNull($inserted);
        $initialPhoto = public_path('foto_dosen'.DIRECTORY_SEPARATOR.$inserted->foto_dosen);
        $this->createdFiles[] = $initialPhoto;
        $this->assertFileExists($initialPhoto);

        $updateResponse = $this->post('/dosen/update/PEG0004', [
            'nip' => '199205142020121009',
            'nama_dosen' => 'Budi Santoso, S.T., M.Kom.',
            'mata_kuliah' => 'Keamanan Jaringan',
            'foto_dosen' => $this->fakePhoto('budi-new.png'),
        ]);
        $updateResponse->assertRedirect('/dosen');

        $updated = DB::table('tb_dosen')->where('id_dosen', 'PEG0004')->first();
        $this->assertSame('Keamanan Jaringan', $updated->mata_kuliah);
        $updatedPhoto = public_path('foto_dosen'.DIRECTORY_SEPARATOR.$updated->foto_dosen);
        $this->createdFiles[] = $updatedPhoto;
        $this->assertFileDoesNotExist($initialPhoto);
        $this->assertFileExists($updatedPhoto);

        $pdfResponse = $this->get('/dosen/print');
        $pdfResponse->assertOk();
        $this->assertSame('application/pdf', $pdfResponse->headers->get('Content-Type'));
        $this->assertStringStartsWith('%PDF-', $pdfResponse->getContent());

        $this->delete('/dosen/delete/PEG0004')->assertRedirect('/dosen');
        $this->assertDatabaseMissing('tb_dosen', ['id_dosen' => 'PEG0004']);
        $this->assertFileDoesNotExist($updatedPhoto);
    }

    public function test_dosen_auto_id_handles_empty_table_and_deleted_middle_gaps(): void
    {
        $model = new M_Dosen();
        $this->assertSame('PEG0004', $model->generateId());

        DB::table('tb_dosen')->where('id_dosen', 'PEG0002')->delete();
        $this->assertSame('PEG0004', $model->generateId());

        DB::table('tb_dosen')->delete();
        $this->assertSame('PEG0001', $model->generateId());
    }

    public function test_mahasiswa_crud_all_11_fields_detail_and_pdf_export(): void
    {
        $admin = User::where('email', 'admin@siakad.test')->firstOrFail();
        $this->actingAs($admin);

        $this->get('/mahasiswa')
            ->assertOk()
            ->assertSee('10603001')
            ->assertSee('Daffa Riyadhul');

        $this->get('/mahasiswa/detail/10603001')
            ->assertOk()
            ->assertSee('Teknologi Informasi dan Komputer')
            ->assertSee('D4 Teknologi Rekayasa Perangkat Lunak')
            ->assertSee('Subang, 14 Mei 2005')
            ->assertSee('Jl. Brigjen Katamso No. 37, Dangdeur, Subang')
            ->assertSee('Islam')
            ->assertSee('Tingkat 2')
            ->assertSee('Semester 3')
            ->assertSee('081234567890');

        $this->get('/mahasiswa/add')
            ->assertOk()
            ->assertSee('10603004');

        $insertResponse = $this->post('/mahasiswa/insert', [
            'nim' => '10603099',
            'nama' => 'Ahmad Fauzan',
            'jurusan' => 'Teknologi Informasi dan Komputer',
            'prodi' => 'D4 Teknologi Rekayasa Perangkat Lunak',
            'ttl' => 'Subang, 02 Februari 2005',
            'alamat' => 'Jl. Ahmad Yani No. 10, Subang',
            'agama' => 'Islam',
            'tingkat' => 2,
            'semester' => 4,
            'nomor_handphone' => '081999888777',
            'foto_mahasiswa' => $this->fakePhoto('ahmad.png'),
        ]);
        $insertResponse->assertRedirect('/mahasiswa');

        $inserted = DB::table('tb_mahasiswa')->where('nim', '10603099')->first();
        $this->assertNotNull($inserted);
        $initialPhoto = public_path('foto_mahasiswa'.DIRECTORY_SEPARATOR.$inserted->foto_mahasiswa);
        $this->createdFiles[] = $initialPhoto;
        $this->assertFileExists($initialPhoto);

        $updateResponse = $this->post('/mahasiswa/update/10603099', [
            'nama' => 'Ahmad Fauzan Hakim',
            'jurusan' => 'Teknologi Informasi dan Komputer',
            'prodi' => 'D3 Sistem Informasi',
            'ttl' => 'Subang, 02 Februari 2005',
            'alamat' => 'Jl. Ahmad Yani No. 25, Subang',
            'agama' => 'Islam',
            'tingkat' => 3,
            'semester' => 5,
            'nomor_handphone' => '081999888778',
            'foto_mahasiswa' => $this->fakePhoto('ahmad-new.png'),
        ]);
        $updateResponse->assertRedirect('/mahasiswa');

        $updated = DB::table('tb_mahasiswa')->where('nim', '10603099')->first();
        $this->assertSame('Ahmad Fauzan Hakim', $updated->nama);
        $this->assertSame(5, (int) $updated->semester);
        $updatedPhoto = public_path('foto_mahasiswa'.DIRECTORY_SEPARATOR.$updated->foto_mahasiswa);
        $this->createdFiles[] = $updatedPhoto;
        $this->assertFileDoesNotExist($initialPhoto);
        $this->assertFileExists($updatedPhoto);

        $pdfResponse = $this->get('/mahasiswa/print');
        $pdfResponse->assertOk();
        $this->assertSame('application/pdf', $pdfResponse->headers->get('Content-Type'));
        $this->assertStringStartsWith('%PDF-', $pdfResponse->getContent());

        $this->delete('/mahasiswa/delete/10603099')->assertRedirect('/mahasiswa');
        $this->assertDatabaseMissing('tb_mahasiswa', ['nim' => '10603099']);
        $this->assertFileDoesNotExist($updatedPhoto);
    }

    public function test_admin_pages_about_user_chart_invoice_and_empty_states(): void
    {
        $admin = User::where('email', 'admin@siakad.test')->firstOrFail();
        $this->actingAs($admin);

        $this->get('/home')->assertOk()->assertSee('Administrator SIAKAD');
        $this->get('/about')->assertOk()->assertSee('Politeknik Negeri Subang');
        $this->get('/user')->assertOk()->assertSee('admin@siakad.test');
        $this->get('/chart')
            ->assertOk()
            ->assertSee('Berapa jumlah pengguna yang terdaftar pada setiap tahun?')
            ->assertSee('D4 Teknologi Rekayasa Perangkat Lunak');

        $this->get('/invoice')
            ->assertOk()
            ->assertSee('INV-2026-001')
            ->assertSee('SIMULASI TAGIHAN UKT');

        $this->get('/invoice?no=INV-2026-002')
            ->assertOk()
            ->assertSee('INV-2026-002')
            ->assertSee('Nabil Andhika Rabbani');

        $this->get('/invoice?no=TIDAK-ADA')->assertNotFound();

        DB::table('tb_invoice')->delete();
        DB::table('tb_dosen')->delete();
        DB::table('tb_mahasiswa')->delete();

        $this->get('/dosen')->assertOk()->assertSee('Belum ada data dosen tersimpan');
        $this->get('/mahasiswa')->assertOk()->assertSee('Belum ada data mahasiswa tersimpan');
        $this->get('/invoice')->assertOk()->assertSee('Belum ada data invoice UKT');
    }
}
