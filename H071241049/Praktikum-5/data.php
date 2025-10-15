<?php
$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT)
    ],
    [
        'email' => 'tika@gmail.com',
        'username' => 'rnratika',
        'name' => 'Nur Atika Binti Ardi',
        'password' => password_hash('tika123', PASSWORD_DEFAULT),
        'gender' => 'Female', 
        'faculty' => 'Ilmu Budaya',
        'batch' => '2025'
    ],
    [
        'email' => 'zalfa@gmail.com',
        'username' => 'faaa.syqh',
        'name' => 'Zalfa Syauqiyah H.',
        'password' => password_hash('zalfa123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Kehutanan',
        'batch' => '2024'
    ],
    [
        'email' => 'daffa@gmail.com',
        'username' => 'daffausmann',
        'name' => 'Muh. Daffa Usman',
        'password' => password_hash('daffa123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Keperawatan',
        'batch' => '2021'
    ],
    [
        'email' => 'iyad@gmail.com',
        'username' => 'iyadfyd',
        'name' => 'Hilmy Affayad',
        'password' => password_hash('iyad123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Teknik',
        'batch' => '2020'
    ],
    [
        'email' => 'kal@gmail.com',
        'username' => 'kal',
        'name' => 'Haikal',
        'password' => password_hash('kal123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Teknik',
        'batch' => '2020'
    ]
];
?>
