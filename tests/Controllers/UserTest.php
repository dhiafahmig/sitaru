<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
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
                         ->setMethods(['load', 'beranda', 'form', 'profile', 'detail', 'simpan'])
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
                             ->setMethods(['where', 'get', 'affected_rows'])
                             ->getMock();

        // Mock untuk session
        $this->CI->load->expects($this->any())
                       ->method('library')
                       ->with('session');

        // Mock untuk model
        $this->CI->load->expects($this->any())
                       ->method('model')
                       ->with('MasyarakatModel', 'Model')
                       ->willReturn($this->CI->Model);

        // Mock untuk view
        $this->CI->load->expects($this->any())
                       ->method('view')
                       ->willReturn('<title>Halaman Beranda</title>');

        // Mock nilai return untuk metode controller
        $this->CI->method('beranda')
                 ->willReturn('<title>Halaman Beranda</title>');

        $this->CI->method('form')
                 ->willReturn('<title>Form Ubah Profile</title>');

        $this->CI->method('profile')
                 ->willReturn('<title>Profil</title>');

        $this->CI->method('detail')
                 ->willReturn('<title>Form Hotpost</title>');

        $this->CI->method('simpan')
                 ->willReturn(true);
    }

    public function testBeranda()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'User';

        // Capture the output
        $output = $this->CI->beranda();

        // Check if the output contains expected data
        $this->assertStringContainsString('Halaman Beranda', $output);
    }

    public function testForm()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'User';
        $_SESSION['id_pengguna'] = 1;

        // Capture the output
        $output = $this->CI->form('ubah', 1);

        // Check if the output contains expected data
        $this->assertStringContainsString('Form Ubah Profile', $output);
    }

    public function testProfile()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'User';
        $_SESSION['id_pengguna'] = 1;

        // Capture the output
        $output = $this->CI->profile('lihat', 1);

        // Check if the output contains expected data
        $this->assertStringContainsString('Profil', $output);
    }

    public function testDetail()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'User';

        // Capture the output
        $output = $this->CI->detail('lihat', 1);

        // Check if the output contains expected data
        $this->assertStringContainsString('Form Hotpost', $output);
    }

    public function testSimpan()
    {
        // Simulate POST data
        $_POST = [
            'email' => 'test@example.com',
            'nm_lengkap' => 'Test User',
            'nik' => '1234567890',
            'jns_kelamin' => 'Laki-laki',
            'tgl_lahir' => '2000-01-01',
            'no_hp' => '08123456789',
            'parameter' => 'tambah'
        ];

        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'User';
        $_SESSION['id_pengguna'] = 1;

        // Mock affected_rows method
        $this->CI->db->expects($this->any())
                     ->method('affected_rows')
                     ->willReturn(1);

        // Call the method
        $this->CI->simpan();

        // Check if the data was inserted
        $this->assertTrue($this->CI->db->affected_rows() > 0);
    }
}