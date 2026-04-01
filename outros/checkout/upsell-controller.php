<?php
/**
 * CONTROLADOR DE UPSELLS
 * Gerencia a ordem e configuração dos upsells
 */
session_start();

// Verificar autenticação
if (!isset($_SESSION['gateway_admin_logged']) || $_SESSION['gateway_admin_logged'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

// Arquivo de configuração dos upsells
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

// Função para carregar configuração
function loadUpsellConfig() {
    global $configFile, $defaultConfig;
    
    if (file_exists($configFile)) {
        $content = file_get_contents($configFile);
        $config = json_decode($content, true);
        return $config ?: $defaultConfig;
    }
    
    return $defaultConfig;
}

// Função para salvar configuração
function saveUpsellConfig($config) {
    global $configFile;
    
    $json = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($configFile, $json) !== false;
}

// Processar requisição
$action = $_GET['action'] ?? $_POST['action'] ?? 'get_config';

switch ($action) {
    case 'get_config':
        $config = loadUpsellConfig();
        echo json_encode([
            'success' => true,
            'config' => $config
        ]);
        break;
        
    case 'update_config':
        $upsells = json_decode($_POST['upsells'] ?? '[]', true);
        
        if (empty($upsells)) {
            echo json_encode([
                'success' => false,
                'message' => 'Dados inválidos'
            ]);
            break;
        }
        
        $config = ['upsells' => $upsells];
        
        if (saveUpsellConfig($config)) {
            echo json_encode([
                'success' => true,
                'message' => 'Configuração de upsells atualizada com sucesso!',
                'config' => $config
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao salvar configuração'
            ]);
        }
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Ação inválida'
        ]);
}
