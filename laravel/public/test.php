<?php
echo "PHP Version: " . phpversion() . "\n";
echo "Loaded Extensions:\n";
$extensions = get_loaded_extensions();
foreach ($extensions as $extension) {
    if (strpos(strtolower($extension), 'pgsql') !== false) {
        echo "- $extension\n";
    }
}
echo "\nPDO Drivers:\n";
$pdo_drivers = PDO::getAvailableDrivers();
foreach ($pdo_drivers as $driver) {
    if (strpos(strtolower($driver), 'pgsql') !== false) {
        echo "- $driver\n";
    }
}
?>
