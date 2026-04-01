<?php
/**
 * API para obter configuração de upsells
 * Retorna a configuração em formato JSON
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$configFile = __DIR__ . '/upsell-config.json';

// Configuração padrão
$defaultConfig = [
    'upsells' => [
        ['id' => '0', 'next' => 'upsell1', 'value' => '2495', 'name' => 'Checkout Principal'],
        ['id' => '1', 'next' => 'upsell2', 'value' => '2495', 'name' => 'Upsell 1'],
        ['id' => '2', 'next' => 'upsell3', 'value' => '1790', 'name' => 'Upsell 2'],
        ['id' => '3', 'next' => 'upsell4', 'value' => '2495', 'name' => 'Upsell 3'],
        ['id' => '4', 'next' => 'upsell5', 'value' => '2495', 'name' => 'Upsell 4'],
        ['id' => '5', 'next' => 'upsell6', 'value' => '2495', 'name' => 'Upsell 5'],
        ['id' => '6', 'next' => 'obrigado', 'value' => '0', 'name' => 'Upsell 6']
    ]
];

if (file_exists($configFile)) {
    $content = file_get_contents($configFile);
    $config = json_decode($content, true);
    echo json_encode($config ?: $defaultConfig);
} else {
    echo json_encode($defaultConfig);
}
