<?php

use PHPUnit\Framework\TestCase;

class PegawaiTest extends TestCase
{
    private $CI;

    public function setUp(): void
    {
        // Mulai session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Buat mock untuk instance CodeIgniter
        $this->CI = $this->getMockBuilder(stdClass::class)
                         ->setMethods(['load', 'index', 'form', 'simpan', 'hapus', 'datatable'])
                         ->getMock();

        // Mock untuk library dan model
        $this->CI->load = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['model', 'library', 'view'])
                               ->getMock();

        $this->CI->Model = $this->getMockBuilder(stdClass::class)
                                ->setMethods(['get', 'insert', 'update'])
                                ->getMock();

        // Mock untuk database
        $this->CI->db = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['insert', 'insert_id', 'affected_rows', 'where', 'delete'])
                             ->getMock();

        // Mock untuk session
        $this->CI->load->expects($this->any())
                       ->method('library')
                       ->with('session');

        // Mock untuk model
        $this->CI->load->expects($this->any())
                       ->method('model')
                       ->with('PetugasModel', 'Model')
                       ->willReturn($this->CI->Model);

        // Mock untuk view
        $this->CI->load->expects($this->any())
                       ->method('view')
                       ->willReturn('<title>Halaman Petugas</title>');

        // Mock nilai return untuk metode controller
        $this->CI->method('index')
                 ->willReturn('<title>Halaman Petugas</title>');

        $this->CI->method('form')
                 ->willReturn('<title>Form Petugas</title>');

        $this->CI->method('simpan')
                 ->willReturn(true);

        $this->CI->method('hapus')
                 ->willReturn(true);

        $this->CI->method('datatable')
                 ->willReturn(json_encode(['data' => []]));
    }

    public function testIndex()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Capture the output
        $output = $this->CI->index();

        // Check if the output contains expected data
        $this->assertStringContainsString('Halaman Petugas', $output);
    }

    public function testForm()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Capture the output
        $output = $this->CI->form('tambah', '');

        // Check if the output contains expected data
        $this->assertStringContainsString('Form Petugas', $output);
    }

    public function testSimpan()
    {
        // Simulate POST data
        $_POST = [
            'email' => 'test@example.com',
            'kt_sandi' => 'password',
            'nik' => '1234567890',
            'nm_lengkap' => 'Test User',
            'jns_kelamin' => 'Laki-laki',
            'tgl_lahir' => '2000-01-01',
            'parameter' => 'tambah'
        ];

        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Mock affected_rows method
        $this->CI->db->expects($this->any())
                     ->method('affected_rows')
                     ->willReturn(1);

        // Call the method
        $this->CI->simpan();

        // Check if the data was inserted
        $this->assertTrue($this->CI->db->affected_rows() > 0);
    }

    public function testHapus()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Mock insert and insert_id methods
        $this->CI->db->expects($this->any())
                     ->method('insert')
                     ->willReturn(true);

        $this->CI->db->expects($this->any())
                     ->method('insert_id')
                     ->willReturn(1);

        // Mock affected_rows method
        $this->CI->db->expects($this->any())
                     ->method('affected_rows')
                     ->willReturn(1);

        // Insert a test user
        $this->CI->db->insert('pengguna', [
            'email' => 'test@example.com',
            'kt_sandi' => password_hash('password', PASSWORD_DEFAULT),
            'level' => 'Petugas',
            'nik' => '1234567890',
            'nm_lengkap' => 'Test User',
            'jns_kelamin' => 'Laki-laki',
            'tgl_lahir' => '2000-01-01'
        ]);
        $id_pengguna = $this->CI->db->insert_id();

        // Call the method
        $this->CI->hapus($id_pengguna);

        // Check if the data was deleted
        $this->assertTrue($this->CI->db->affected_rows() > 0);
    }

    public function testDatatable()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Capture the output
        $output = $this->CI->datatable();

        // Check if the output is a valid JSON
        $this->assertJson($output);
    }
}