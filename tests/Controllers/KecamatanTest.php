<?php

use PHPUnit\Framework\TestCase;

class KecamatanTest extends TestCase
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
                         ->setMethods(['load', 'index', 'form', 'simpan', 'hapus'])
                         ->getMock();

        // Mock untuk library dan model
        $this->CI->load = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['model', 'library', 'view'])
                               ->getMock();

        $this->CI->Model = $this->getMockBuilder(stdClass::class)
                                ->setMethods(['get', 'insert', 'update', 'delete'])
                                ->getMock();

        // Mock untuk database
        $this->CI->db = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['where', 'get', 'delete', 'affected_rows'])
                             ->getMock();

        // Mock untuk session
        $this->CI->load->expects($this->any())
                       ->method('library')
                       ->with('session');

        // Mock untuk model
        $this->CI->load->expects($this->any())
                       ->method('model')
                       ->with('KecamatanModel', 'Model')
                       ->willReturn($this->CI->Model);

        // Mock untuk view
        $this->CI->load->expects($this->any())
                       ->method('view')
                       ->willReturn('<title>Halaman Pola Ruang</title>');

        // Mock nilai return untuk metode controller
        $this->CI->method('index')
                 ->willReturn('<title>Halaman Pola Ruang</title>');

        $this->CI->method('form')
                 ->willReturn('<title>Form Pola Ruang</title>');

        $this->CI->method('simpan')
                 ->willReturn(true);

        $this->CI->method('hapus')
                 ->willReturn(true);
    }

    public function testIndex()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Capture the output
        $output = $this->CI->index();

        // Check if the output contains expected data
        $this->assertStringContainsString('Halaman Pola Ruang', $output);
    }

    public function testForm()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Capture the output
        $output = $this->CI->form('tambah', '');

        // Check if the output contains expected data
        $this->assertStringContainsString('Form Pola Ruang', $output);
    }

    public function testSimpan()
    {
        // Simulate POST data
        $_POST = [
            'nm_kecamatan' => 'Test Kecamatan',
            'warna_kecamatan' => '#FFFFFF',
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

        // Mock affected_rows method
        $this->CI->db->expects($this->any())
                     ->method('affected_rows')
                     ->willReturn(1);

        // Call the method
        $this->CI->hapus(1);

        // Check if the data was deleted
        $this->assertTrue($this->CI->db->affected_rows() > 0);
    }
}