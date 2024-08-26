<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com'; // Ganti dengan SMTP host Anda
$config['smtp_port'] = 465; // Ganti dengan port SMTP Anda (25, 465, atau 587)
$config['smtp_user'] = 'fahmighufron@gmail.com'; // Ganti dengan email Anda
$config['smtp_pass'] = 'Dhiafahmi23'; // Ganti dengan password email Anda
$config['mailtype'] = 'html'; // Tipe email (html atau text)
$config['charset'] = 'utf-8'; // Charset email
$config['newline'] = "\r\n"; // Newline karakter
$config['wordwrap'] = TRUE; // Word wrap
$config['smtp_crypto'] = 'ssl'; // Ganti dengan 'ssl' jika menggunakan port 465
