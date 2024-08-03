<?php
// Data menu untuk sidebar
$menuItems = [
    ['icon' => 'tachometer-alt', 'text' => 'Dashboard', 'file' => 'dashbord.php'],
    ['icon' => 'users', 'text' => 'Data Sensor', 'file' => 'data.php'],
    ['icon' => 'power-off', 'text' => 'Button', 'isButton' => true, 'isToggle' => true, 'isActive' => false, 'file' => 'button.php'],
    ['icon' => 'sign-out-alt', 'active' => true,'text' => 'Login', 'file' => 'logout.php'],
];

// Fungsi untuk membuat item menu
function createMenuItem($item) {
    $activeClass = $item['active'] ?? false ? 'active' : '';
    $file = $item['file'] ?? '#';
    return "
        <li class='nav-item {$activeClass}'>
            <a class='nav-link' href='{$file}'>
                <i class='fas fa-{$item['icon']}'></i>
                <span>{$item['text']}</span>
            </a>
        </li>
    ";
}
?>