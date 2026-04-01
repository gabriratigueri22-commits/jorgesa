<?php
// Headers já definidos pelo roteador pagamento.php
// NÃO remova este comentário - evita redefinição de headers

// Configurações de erro (sem headers)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Função para gerar CPF válido
function gerarCPF() {
    $cpf = '';
    for ($i = 0; $i < 9; $i++) {
        $cpf .= rand(0, 9);
    }

    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += intval($cpf[$i]) * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    $cpf .= $digito1;

    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += intval($cpf[$i]) * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;
    $cpf .= $digito2;

    $invalidos = [
        '00000000000', '11111111111', '22222222222', '33333333333', 
        '44444444444', '55555555555', '66666666666', '77777777777', 
        '88888888888', '99999999999'
    ];

    if (in_array($cpf, $invalidos)) {
        return gerarCPF();
    }

    return $cpf;
}

// Função para gerar email dinâmico
function gerarEmail($nome) {
    $dominios = [
        '@gmail.com', '@hotmail.com', '@yahoo.com.br', '@outlook.com', 
        '@uol.com.br', '@bol.com.br', '@terra.com.br', '@ig.com.br',
        '@globo.com', '@r7.com', '@live.com', '@msn.com'
    ];
    
    // Remove acentos e espaços do nome
    $nomeEmail = strtolower($nome);
    $nomeEmail = str_replace(' ', '', $nomeEmail);
    $nomeEmail = preg_replace('/[^a-z0-9]/', '', $nomeEmail);
    
    // Adiciona números aleatórios ao final
    $numeros = rand(10, 9999);
    $dominio = $dominios[array_rand($dominios)];
    
    return $nomeEmail . $numeros . $dominio;
}

try {
    // Configurações da nova API MangoFy
    $apiUrl = 'https://checkout.mangofy.com.br/api/v1/payment';
    $secretKey = '2631dbc46e3b752b7a988cb4dea292a03g9uwn7dvxinxsobwzm5qyzqnd0hbjt';
    $apiKey = 'b933776a91cd1dc14374edf782f20168';

    // Conecta ao SQLite (arquivo de banco de dados)
    $dbPath = __DIR__ . '/database.sqlite'; // Caminho para o arquivo SQLite
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se a tabela 'pedidos' existe e cria se necessário
    $db->exec("CREATE TABLE IF NOT EXISTS pedidos (
        transaction_id TEXT PRIMARY KEY,
        status TEXT NOT NULL,
        valor INTEGER NOT NULL,
        nome TEXT,
        email TEXT,
        cpf TEXT,
        utm_params TEXT,
        created_at TEXT,
        updated_at TEXT
    )");

    // Recebe os parâmetros
    $valor = isset($_POST['valor']) ? intval($_POST['valor']) : 8340; // Valor dinâmico ou padrão
    $valor_centavos = $valor;

    if (!$valor || $valor <= 0) {
        throw new Exception('Valor inválido');
    }

    // Gera dados do cliente
    $nomes_masculinos = [
        'Joao', 'Pedro', 'Lucas', 'Miguel', 'Arthur', 'Gabriel', 'Bernardo', 'Rafael',
        'Gustavo', 'Felipe', 'Daniel', 'Matheus', 'Bruno', 'Thiago', 'Carlos',
        'Anderson', 'Eduardo', 'Vinicius', 'Leonardo', 'Diego', 'Rodrigo', 'Samuel',
        'Alexandre', 'Henrique', 'Igor', 'Marcelo', 'Renan', 'Vitor', 'Caio', 'Victor',
        'Antonio', 'Paulo', 'Luiz', 'Fernando', 'Roberto', 'Jorge', 'Alan', 'Elias',
        'Murilo', 'Ricardo', 'Luciano', 'Wesley', 'Adriano', 'Otavio', 'Tiago', 'Jose',
        'Jonathan', 'Cristiano', 'Leandro', 'Nathan'
    ];
    

    $nomes_femininos = [
        'Maria', 'Ana', 'Julia', 'Sofia', 'Isabella', 'Helena', 'Valentina', 'Laura',
        'Alice', 'Manuela', 'Beatriz', 'Clara', 'Luiza', 'Mariana', 'Sophia',
        'Camila', 'Larissa', 'Livia', 'Fernanda', 'Bruna', 'Leticia', 'Aline',
        'Jéssica', 'Patricia', 'Tatiane', 'Vanessa', 'Bianca', 'Juliana', 'Karina',
        'Tainara', 'Carla', 'Caroline', 'Cristina', 'Gabriela', 'Daniela', 'Evelyn',
        'Isadora', 'Renata', 'Flavia', 'Nathalia', 'Debora', 'Pamela', 'Lorena',
        'Rafaela', 'Cintia', 'Talita', 'Nicole', 'Lara', 'Clarice', 'Simone'
    ];
    

    $sobrenomes = [
        'Silva', 'Santos', 'Oliveira', 'Souza', 'Rodrigues', 'Ferreira', 'Alves',
        'Pereira', 'Lima', 'Gomes', 'Costa', 'Ribeiro', 'Martins', 'Carvalho',
        'Almeida', 'Lopes', 'Soares', 'Fernandes', 'Vieira', 'Barbosa',
        'Araujo', 'Dias', 'Teixeira', 'Moura', 'Castro', 'Campos', 'Reis', 'Pinto',
        'Mendes', 'Farias', 'Cavalcante', 'Batista', 'Monteiro', 'Machado', 'Ramos',
        'Cardoso', 'Freitas', 'Borges', 'Nascimento', 'Antunes', 'Xavier', 'Miranda',
        'Figueiredo', 'Duarte', 'Coelho', 'Andrade', 'Tavares', 'Peixoto', 'Correia',
        'Barros'
    ];
    

    // Parâmetros UTM
    $utmParams = [
        'utm_source' => $_POST['utm_source'] ?? null,
        'utm_medium' => $_POST['utm_medium'] ?? null,
        'utm_campaign' => $_POST['utm_campaign'] ?? null,
        'utm_content' => $_POST['utm_content'] ?? null,
        'utm_term' => $_POST['utm_term'] ?? null,
        'xcod' => $_POST['xcod'] ?? null,
        'sck' => $_POST['sck'] ?? null
    ];

    $utmParams = array_filter($utmParams, function($value) {
        return $value !== null && $value !== '';
    });

    error_log("[Pagamento] 📊 Parâmetros UTM recebidos: " . json_encode($utmParams));

    $utmQuery = http_build_query($utmParams);

    // RECEBE DADOS DO CLIENTE DA REQUISIÇÃO (se enviados)
    $nome_cliente = isset($_POST['nome']) && !empty($_POST['nome']) ? $_POST['nome'] : null;
    $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;
    $cpf = isset($_POST['cpf']) && !empty($_POST['cpf']) ? preg_replace('/[^0-9]/', '', $_POST['cpf']) : null;
    $telefone = isset($_POST['telefone']) && !empty($_POST['telefone']) ? preg_replace('/[^0-9]/', '', $_POST['telefone']) : null;

    error_log("[Pagamento] 📥 Dados recebidos da requisição: " . json_encode([
        'nome' => $nome_cliente,
        'email' => $email,
        'cpf' => $cpf,
        'telefone' => $telefone
    ]));

    // FALLBACK: Gera dados do cliente apenas se não foram enviados
    if (!$nome_cliente || !$email || !$cpf) {
        error_log("[Pagamento] ⚠️ Dados incompletos. Gerando dados falsos como fallback...");
        
        $genero = rand(0, 1);
        $nome = $genero ? 
            $nomes_masculinos[array_rand($nomes_masculinos)] : 
            $nomes_femininos[array_rand($nomes_femininos)];
        
        $sobrenome1 = $sobrenomes[array_rand($sobrenomes)];
        $sobrenome2 = $sobrenomes[array_rand($sobrenomes)];
        
        $nome_cliente = $nome_cliente ?: "$nome $sobrenome1 $sobrenome2";
        $email = $email ?: gerarEmail($nome_cliente);
        $cpf = $cpf ?: gerarCPF();
        
        error_log("[Pagamento] 🤖 Dados falsos gerados: " . json_encode([
            'nome' => $nome_cliente,
            'email' => $email,
            'cpf' => $cpf
        ]));
    } else {
        error_log("[Pagamento] ✅ Usando dados reais enviados na requisição");
    }

    // Fallback para telefone
    if (!$telefone) {
        $telefone = '11999999999';
        error_log("[Pagamento] 📱 Telefone não enviado. Usando fallback: " . $telefone);
    }

    error_log("[MangoFy] 📝 Preparando dados para envio: " . json_encode([
        'valor' => $valor,
        'valor_centavos' => $valor_centavos,
        'nome' => $nome_cliente,
        'email' => $email,
        'cpf' => $cpf
    ]));

    // Novo payload para a API MangoFy
    $data = [
        "store_code" => $apiKey,
        "external_code" => uniqid('deposito_'),
        "payment_method" => "pix",
        "payment_format" => "regular",
        "installments" => 1,
        "payment_amount" => $valor_centavos,
        "shipping_amount" => 0,
        "postback_url" => "https://" . $_SERVER['HTTP_HOST'] . "/checkout/webhook.php",
        "items" => [
            [
                "code" => "1",
                "name" => "Front deposito",
                "amount" => $valor_centavos,
                "total" => 1
            ]
        ],
        "customer" => [
            "email" => $email,
            "name" => $nome_cliente,
            "document" => $cpf,
            "phone" => $telefone,
            "ip" => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ],
        "pix" => [
            "expires_in_days" => 1
        ],
        "extra" => [
            "utm_source" => $utmParams['utm_source'] ?? '',
            "utm_medium" => $utmParams['utm_medium'] ?? '',
            "utm_campaign" => $utmParams['utm_campaign'] ?? '',
            "utm_content" => $utmParams['utm_content'] ?? '',
            "utm_term" => $utmParams['utm_term'] ?? '',
            "xcod" => $utmParams['xcod'] ?? '',
            "sck" => $utmParams['sck'] ?? ''
        ]
    ];

    error_log("[MangoFy] 🌐 URL da requisição: " . $apiUrl);
    error_log("[MangoFy] 📦 Dados enviados: " . json_encode($data));

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $secretKey,
        'Store-Code: ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    $curlErrno = curl_errno($ch);

    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    error_log("[MangoFy] 🔍 Detalhes da requisição cURL:\n" . $verboseLog);

    if ($curlError) {
        error_log("[MangoFy] ❌ Erro cURL: " . $curlError . " (errno: " . $curlErrno . ")");
        throw new Exception("Erro na requisição: " . $curlError);
    }

    curl_close($ch);

    error_log("[MangoFy] 📊 HTTP Status Code: " . $httpCode);
    error_log("[MangoFy] 📄 Resposta bruta: " . $response);

    if ($httpCode !== 200) {
        throw new Exception("Erro na API: HTTP " . $httpCode . " - " . $response);
    }

    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erro ao decodificar resposta: " . json_last_error_msg() . " - Resposta: " . $response);
    }

    if (!isset($result['payment_code'])) {
        throw new Exception("payment_code não encontrado na resposta da API");
    }

    // Adaptar a resposta da MangoFy para manter compatibilidade
    $payment_id = $result['payment_code'];
    
    // Buscar o código PIX da resposta da API MangoFy
    $pixCode = null;
    
    // Log da resposta completa para debug
    error_log("[MangoFy] 🔍 Analisando resposta completa: " . print_r($result, true));
    
    if (isset($result['pix']['pix_qrcode_text'])) {
        $pixCode = $result['pix']['pix_qrcode_text'];
        error_log("[MangoFy] 📱 PIX Code encontrado em 'pix.pix_qrcode_text': " . $pixCode);
    } elseif (isset($result['pix']['pix_link'])) {
        $pixCode = $result['pix']['pix_link'];
        error_log("[MangoFy] 📱 PIX Link encontrado em 'pix.pix_link': " . $pixCode);
    } elseif (isset($result['pix_code'])) {
        $pixCode = $result['pix_code'];
        error_log("[MangoFy] 📱 PIX Code encontrado em 'pix_code': " . $pixCode);
    } elseif (isset($result['pix']['code'])) {
        $pixCode = $result['pix']['code'];
        error_log("[MangoFy] 📱 PIX Code encontrado em 'pix.code': " . $pixCode);
    } else {
        error_log("[MangoFy] ⚠️ PIX Code não encontrado na resposta");
    }

    // Salva os dados no SQLite
    $stmt = $db->prepare("INSERT INTO pedidos (transaction_id, status, valor, nome, email, cpf, utm_params, created_at) 
        VALUES (:transaction_id, 'pending', :valor, :nome, :email, :cpf, :utm_params, :created_at)");
    $stmt->execute([
        'transaction_id' => $payment_id,
        'valor' => $valor_centavos,
        'nome' => $nome_cliente,
        'email' => $email,
        'cpf' => $cpf,
        'utm_params' => json_encode($utmParams),
        'created_at' => date('c')
    ]);

    session_start();
    $_SESSION['payment_id'] = $payment_id;

    error_log("[MangoFy] 💳 Transação criada com sucesso: " . $payment_id);
    error_log("[MangoFy] 📄 Resposta completa da API: " . $response);
    error_log("[MangoFy] 🔑 Token gerado: " . $payment_id);

    error_log("[Sistema] 📡 Iniciando comunicação com utmify-pendente.php");

    $utmifyData = [
        'orderId' => $payment_id,
        'platform' => 'MinhaPlataforma',
        'paymentMethod' => 'pix',
        'status' => 'waiting_payment',
        'createdAt' => date('Y-m-d H:i:s'),
        'approvedDate' => null,
        'refundedAt' => null,
        'customer' => [
            'name' => $nome_cliente,
            'email' => $email,
            'phone' => $telefone,
            'document' => $cpf,
            'country' => 'BR',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null
        ],
        'products' => [
            [
                'id' => uniqid('PROD_'),
                'name' => 'taxa',
                'planId' => null,
                'planName' => null,
                'quantity' => 1,
                'priceInCents' => $valor_centavos
            ]
        ],
        'trackingParameters' => $utmParams,
        'commission' => [
            'totalPriceInCents' => $valor_centavos,
            'gatewayFeeInCents' => 0,
            'userCommissionInCents' => $valor_centavos
        ],
        'isTest' => false
    ];

    error_log("[Utmify] 📦 Preparando dados para envio ao utmify-pendente.php: " . json_encode($utmifyData));

    // Envia para utmify-pendente.php
    error_log("[Sistema] 📡 Enviando requisição POST para ../utmify-pendente.php");
    
    $serverUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $utmifyUrl = $serverUrl . "/utmify-pendente.php";
    error_log("[Sistema] 🔍 URL do utmify-pendente.php: " . $utmifyUrl);
    
    $ch = curl_init($utmifyUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($utmifyData),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $utmifyResponse = curl_exec($ch);
    $utmifyHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $utmifyError = curl_error($ch);
    $utmifyErrno = curl_errno($ch);
    
    error_log("[Sistema] 🔍 Detalhes da requisição Utmify: " . print_r([
        'url' => $utmifyUrl,
        'status' => $utmifyHttpCode,
        'resposta' => $utmifyResponse,
        'erro' => $utmifyError,
        'errno' => $utmifyErrno
    ], true));
    
    curl_close($ch);

    error_log("[Sistema] ✉️ Resposta do utmify-pendente.php: " . $utmifyResponse);
    error_log("[Sistema] 📊 Status code do utmify-pendente.php: " . $utmifyHttpCode);

    if ($utmifyHttpCode !== 200) {
        error_log("[Sistema] ❌ Erro ao enviar dados para utmify-pendente.php: " . $utmifyResponse);
    } else {
        error_log("[Sistema] ✅ Dados enviados com sucesso para utmify-pendente.php");
    }

    // Preparar resposta mantendo a mesma estrutura para o frontend
    $responseData = [
        'success' => true,
        'token' => $payment_id,
        'pixCode' => $pixCode,
        'qrCodeUrl' => $pixCode ? 
            'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($pixCode) . '&size=300x300&charset-source=UTF-8&charset-target=UTF-8&qzone=1&format=png&ecc=L' : 
            null,
        'valor' => $valor,
        'logs' => [
            'utmParams' => $utmParams,
            'transacao' => [
                'valor' => $valor,
                'cliente' => $nome_cliente,
                'email' => $email,
                'cpf' => $cpf
            ],
            'utmifyResponse' => [
                'status' => $utmifyHttpCode,
                'resposta' => $utmifyResponse
            ]
        ]
    ];

    error_log("[MangoFy] 📤 Enviando resposta ao frontend: " . json_encode($responseData));
    echo json_encode($responseData);

} catch (Exception $e) {
    error_log("[MangoFy] ❌ Erro: " . $e->getMessage());
    error_log("[MangoFy] 🔍 Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao gerar o PIX: ' . $e->getMessage()
    ]);
}
?>