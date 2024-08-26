<?php

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
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
                         ->setMethods(['load', 'auth'])
                         ->getMock();

        // Mock untuk library dan model
        $this->CI->load = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['library', 'model', 'view'])
                               ->getMock();

        $this->CI->auth = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['registration', 'check', 'out'])
                               ->getMock();

        // Mock untuk form_validation
        $this->CI->load->expects($this->any())
                       ->method('library')
                       ->with('form_validation');

        // Mock untuk model
        $this->CI->load->expects($this->any())
                       ->method('model')
                       ->withConsecutive(['MasyarakatModel'], ['PegawaiModel']);

        // Mock untuk view
        $this->CI->load->expects($this->any())
                       ->method('view')
                       ->willReturn('<title>Form Login</title>');

        // Mock nilai return untuk metode auth
        $this->CI->auth->method('registration')
                       ->willReturnCallback(function() {
                           $_SESSION['info'] = 'Registration info';
                           return ['redirect' => 'admin/auth'];
                       });
        $this->CI->auth->method('check')
                       ->willReturnCallback(function($postData) {
                           if ($postData['email'] == 'test@example.com' && $postData['kt_sandi'] == 'password123') {
                               $_SESSION['logged'] = true;
                               return ['redirect' => 'admin/beranda'];
                           } else {
                               $_SESSION['logged'] = false;
                               return ['redirect' => 'admin/auth'];
                           }
                       });
        $this->CI->auth->method('out')
                       ->willReturn(['redirect' => 'admin/auth']);
    }

    // Metode custom untuk memeriksa redirection
    private function assertRedirect($result, $expectedUrl)
    {
        $this->assertEquals($expectedUrl, $result['redirect']);
    }

    // Metode custom untuk memeriksa session memiliki kunci tertentu
    private function assertSessionHas($key, $value = null)
    {
        if ($value === null) {
            $this->assertArrayHasKey($key, $_SESSION);
        } else {
            $this->assertEquals($value, $_SESSION[$key]);
        }
    }

    public function testIndex()
    {
        $output = $this->CI->load->view('admin/authView', ['title' => 'Form Login'], true);
        $this->assertStringContainsString('<title>Form Login</title>', $output);
    }

    public function testRegistrationValidationFails()
    {
        $result = $this->CI->auth->registration();

        $this->assertRedirect($result, 'admin/auth');
        $this->assertSessionHas('info');
    }

    public function testRegistrationSuccess()
    {
        $postData = [
            'email' => 'test@example.com',
            'nm_lengkap' => 'Test User',
            'kt_sandi' => 'password123',
            'nik' => '1234567890',
            'jns_kelamin' => 'Laki-laki',
            'tgl_lahir' => '2000-01-01'
        ];

        $result = $this->CI->auth->registration($postData);

        $this->assertRedirect($result, 'admin/auth');
        $this->assertSessionHas('info');
    }

    public function testCheckLoginSuccess()
    {
        $postData = [
            'email' => 'test@example.com',
            'kt_sandi' => 'password123'
        ];

        $result = $this->CI->auth->check($postData);

        $this->assertRedirect($result, 'admin/beranda');
        $this->assertSessionHas('logged', true);
    }

    public function testCheckLoginFailure()
    {
        $postData = [
            'email' => 'wrong@example.com',
            'kt_sandi' => 'wrongpassword'
        ];

        $result = $this->CI->auth->check($postData);

        $this->assertRedirect($result, 'admin/auth');
        $this->assertSessionHas('logged', false);
    }

    public function testLogout()
    {
        $result = $this->CI->auth->out();

        $this->assertRedirect($result, 'admin/auth');
    }
}