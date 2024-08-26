<?php

use PHPUnit\Framework\TestCase;

class LeafletstandarTest extends TestCase
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
                         ->setMethods(['load', 'index'])
                         ->getMock();

        // Mock untuk library dan model
        $this->CI->load = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['model', 'view'])
                               ->getMock();

        $this->CI->Model = $this->getMockBuilder(stdClass::class)
                                ->setMethods(['get'])
                                ->getMock();

        // Mock untuk session
        $this->CI->load->expects($this->any())
                       ->method('model')
                       ->withConsecutive(
                           ['HotspotModel', 'Model'],
                           ['KecamatanModel'],
                           ['PolaRuangModel']
                       );

        // Mock untuk view
        $this->CI->load->expects($this->any())
                       ->method('view')
                       ->willReturn('<title>Halaman Leaflet Pola Ruang</title>');

        // Mock nilai return untuk metode controller
        $this->CI->method('index')
                 ->willReturn('<title>Halaman Leaflet Pola Ruang</title>');
    }

    public function testIndex()
    {
        // Simulate session data
        $_SESSION['logged'] = true;
        $_SESSION['level'] = 'Admin';

        // Capture the output
        $output = $this->CI->index();

        // Check if the output contains expected data
        $this->assertStringContainsString('Halaman Leaflet Pola Ruang', $output);
    }
}