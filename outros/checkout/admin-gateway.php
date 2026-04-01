<?php
/**
 * PAINEL ADMINISTRATIVO - CONTROLE DE GATEWAY
 */
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Gateway - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-light: #a78bfa;
            --success: #10b981;
            --danger: #ef4444;
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border: #334155;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-primary);
        }

        .container {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
            padding: 48px;
        }

        .header {
            margin-bottom: 48px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 24px;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 8px;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .header-icon i {
            font-size: 24px;
        }

        .header h1 {
            color: var(--text-primary);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .header h2 i {
            margin-right: 8px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 15px;
            margin-left: 64px;
        }

        .login-box {
            max-width: 420px;
            margin: 0 auto;
        }

        .login-box h2 {
            color: var(--text-primary);
            margin-bottom: 32px;
            font-size: 24px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            color: var(--text-primary);
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-logout {
            background: var(--danger);
            color: white;
            margin-bottom: 32px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .btn-logout i {
            font-size: 16px;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
            border-bottom: 1px solid var(--border);
        }

        .tab-btn {
            padding: 12px 24px;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 2px solid transparent;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            color: var(--text-primary);
        }

        .tab-btn.active {
            color: var(--primary-light);
            border-bottom-color: var(--primary);
        }

        .gateway-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .gateway-card {
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .gateway-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .gateway-card.active {
            background: rgba(139, 92, 246, 0.1);
            border-color: var(--primary);
        }

        .gateway-icon {
            width: 56px;
            height: 56px;
            background: var(--bg-card);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        .gateway-icon img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .gateway-card:hover .gateway-icon {
            background: rgba(139, 92, 246, 0.15);
            transform: scale(1.08);
        }

        .gateway-card:hover .gateway-icon img {
            transform: scale(1.1);
        }

        .gateway-card.active .gateway-icon {
            background: rgba(139, 92, 246, 0.2);
        }

        .gateway-card.active .gateway-icon img {
            transform: scale(1.05);
        }

        .gateway-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .gateway-card .status {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .gateway-card.active .status {
            color: var(--primary-light);
        }

        .active-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--success);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: none;
            font-weight: 500;
            font-size: 14px;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .loading {
            text-align: center;
            padding: 48px;
            color: var(--text-secondary);
            font-size: 15px;
        }

        .webhook-info {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }

        .webhook-info h3 {
            color: #60a5fa;
            margin-bottom: 8px;
            font-size: 15px;
            font-weight: 600;
        }

        .webhook-info p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
        }

        .webhook-card {
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .webhook-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .webhook-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-card);
            border-radius: 10px;
        }

        .webhook-icon img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .webhook-icon i {
            font-size: 22px;
            color: var(--primary);
        }

        .webhook-info h3 i {
            margin-right: 8px;
        }

        .webhook-header h3 {
            color: var(--text-primary);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .webhook-desc {
            color: var(--text-secondary);
            font-size: 13px;
        }

        .webhook-url-box {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .webhook-url {
            flex: 1;
            padding: 10px 14px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--primary-light);
            font-size: 13px;
            font-family: 'Courier New', monospace;
        }

        .webhook-url:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-copy {
            padding: 10px 20px;
            background: var(--primary);
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-copy:hover {
            background: var(--primary-dark);
        }

        .btn-copy.copied {
            background: var(--success);
        }

        .btn-copy i {
            font-size: 14px;
        }

        .loading i {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Estilos do Preview */
        .preview-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            height: 80vh;
        }

        .preview-controls {
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            overflow-y: auto;
        }

        .preview-iframe-container {
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            position: relative;
        }

        .preview-iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 8px;
            background: white;
        }

        .preview-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .preview-title {
            color: var(--text-primary);
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            flex: 1;
        }

        .preview-refresh {
            background: var(--primary);
            border: none;
            border-radius: 6px;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-refresh:hover {
            background: var(--primary-dark);
        }

        .preview-form-group {
            margin-bottom: 20px;
        }

        .preview-form-group label {
            display: block;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .preview-form-group input {
            width: 100%;
            padding: 10px 12px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .preview-form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
        }

        .preview-updating {
            position: relative;
        }

        .preview-updating::after {
            content: '⚡';
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 14px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Estilos para upload de imagem */
        .upload-container {
            border: 2px dashed var(--border);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 12px;
        }

        .upload-container:hover {
            border-color: var(--primary);
            background: rgba(139, 92, 246, 0.05);
        }

        .upload-container.dragover {
            border-color: var(--primary);
            background: rgba(139, 92, 246, 0.1);
        }

        .upload-input {
            display: none;
        }

        .upload-preview {
            max-width: 200px;
            max-height: 150px;
            border-radius: 6px;
            margin: 10px auto;
            display: block;
        }

        .upload-text {
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .upload-button {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            margin: 5px;
        }

        .upload-button:hover {
            background: var(--primary-dark);
        }

        .upload-url-toggle {
            background: var(--text-secondary);
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-top: 8px;
        }

        .upload-url-toggle:hover {
            background: var(--primary);
        }

        .image-option {
            margin-bottom: 16px;
        }

        .image-option-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .image-tab {
            padding: 6px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .image-tab.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .image-tab:hover:not(.active) {
            border-color: var(--primary);
        }

        .preview-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--text-secondary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 1200px) {
            .preview-container {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .preview-iframe-container {
                height: 600px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 32px 24px;
            }

            .gateway-cards {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }

            .webhook-url-box {
                flex-direction: column;
            }

            .btn-copy {
                width: 100%;
            }

            .modal-content {
                padding: 24px;
                margin: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-top">
                <div class="header-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <h1>Controle de gateway</h1>
            </div>
            <p>Gerencie e monitore gateways de pagamento ativos</p>
        </div>

        <div id="alertBox" class="alert"></div>

        <!-- Login Box -->
        <div id="loginBox" class="login-box" style="display: none;">
            <h2><i class="fa-solid fa-lock"></i> Autenticação Necessária</h2>
            <form id="loginForm">
                <div class="form-group">
                    <label for="password">Senha de Administrador</label>
                    <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary">Entrar no Painel</button>
            </form>
        </div>

        <!-- Admin Panel -->
        <div id="adminPanel" style="display: none;">
            <button id="logoutBtn" class="btn btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</button>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab-btn active" data-tab="gateways">
                    <i class="fa-solid fa-credit-card"></i>
                    Gateways
                </button>
                <button class="tab-btn" data-tab="webhooks">
                    <i class="fa-solid fa-webhook"></i>
                    Webhooks
                </button>
                <button class="tab-btn" data-tab="config">
                    <i class="fa-solid fa-gear"></i>
                    Configurações
                </button>
                <button class="tab-btn" data-tab="preview">
                    <i class="fa-solid fa-eye"></i>
                    Preview
                </button>
                <button class="tab-btn" data-tab="tiktok">
                    <i class="fa-brands fa-tiktok"></i>
                    TikTok Pixels
                </button>
                <button class="tab-btn" data-tab="upsells">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    Upsells
                </button>
            </div>

            <div id="loadingBox" class="loading">
                <i class="fa-solid fa-spinner fa-spin"></i> Carregando configuração...
            </div>

            <div id="gatewayBox" class="tab-content" style="display: none;">
                <div class="gateway-cards">
                    <div class="gateway-card" data-gateway="paradise">
                        <div class="gateway-icon">
                            <img src="https://raichu-uploads.s3.amazonaws.com/logo_paradise-tecnologia-servicos-e-pagamentos-ltda_d7diDL.png" alt="Paradise">
                        </div>
                        <h3>Paradise Pags</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="dutty">
                        <div class="gateway-icon">
                            <img src="https://app.duttyfy.com.br/favicon.ico" alt="DuttyOnPay">
                        </div>
                        <h3>DuttyOnPay</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="mangofy">
                        <div class="gateway-icon">
                            <img src="https://framerusercontent.com/images/vM4i9kiMoQnOShIVBLDFcEF31xU.png" alt="MangoFy">
                        </div>
                        <h3>MangoFy</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="iron">
                        <div class="gateway-icon">
                            <img src="https://ironpayapp.com.br/wp-content/uploads/2025/07/Favicon-70x70.png" alt="IronPay">
                        </div>
                        <h3>IronPay</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="ghost">
                        <div class="gateway-icon">
                            <img src="https://files.readme.io/f8bdd9c07f85edda324c037dd88212bc50047f48d0a6c6c0b7ebc6721e3c5733-small-icon.png" alt="Ghost Pays">
                        </div>
                        <h3>Hygros</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="buck">
                        <div class="gateway-icon">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjx_WWXra0rlcKE_uF3loJuzc3Evj5G3Tkvw&s" alt="BuckPay">
                        </div>
                        <h3>BuckPay</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="naut">
                        <div class="gateway-icon">
                            <img src="https://navenaut.com/_next/static/media/box-icon-naut-yellow.bd3780db.svg" alt="Naut">
                        </div>
                        <h3>Naut</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="zero">
                        <div class="gateway-icon">
                            <img src="https://storage.googleapis.com/gpt-engineer-file-uploads/Hv82OPNoNiXWe4ZBlPlPGK2yvKS2/uploads/1758545117335-zeroone_favicon.svg" alt="ZeroOnePay">
                        </div>
                        <h3>ZeroOnePay</h3>
                        <div class="status">Inativo</div>
                    </div>

                    <div class="gateway-card" data-gateway="manutencao">
                        <div class="gateway-icon">
                            <i class="fa-solid fa-wrench"></i>
                        </div>
                        <h3>astro pay (inacabado)</h3>
                        <div class="status">Inativo</div>
                    </div>
                </div>
            </div>

            <!-- Webhooks Tab -->
            <div id="webhooksBox" class="tab-content" style="display: none;">
                <div class="webhooks-section">
                    <div class="webhook-info">
                        <h3><i class="fa-solid fa-circle-info"></i> Como usar os Webhooks</h3>
                        <p>Configure estes URLs nos painéis dos gateways de pagamento para receber notificações automáticas de pagamentos aprovados, estornos e outros eventos.</p>
                    </div>

                    <!-- Webhooks por Gateway -->
                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <img src="https://raichu-uploads.s3.amazonaws.com/logo_paradise-tecnologia-servicos-e-pagamentos-ltda_d7diDL.png" alt="Paradise">
                            </div>
                            <div>
                                <h3>Paradise Pags</h3>
                                <p class="webhook-desc">Webhook específico para Paradise Pags</p>
                            </div>
                        </div>
                        <div class="webhook-url-box">
                            <input type="text" class="webhook-url" value="" data-webhook="webhook-paradise.php" readonly>
                            <button class="btn-copy" onclick="copyWebhook(this)">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>

                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <img src="https://navenaut.com/_next/static/media/box-icon-naut-yellow.bd3780db.svg" alt="Naut">
                            </div>
                            <div>
                                <h3>Naut</h3>
                                <p class="webhook-desc">Webhook específico para Naut</p>
                            </div>
                        </div>
                        <div class="webhook-url-box">
                            <input type="text" class="webhook-url" value="" data-webhook="webhook-naut.php" readonly>
                            <button class="btn-copy" onclick="copyWebhook(this)">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>

                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <img src="https://ironpayapp.com.br/wp-content/uploads/2025/07/Favicon-70x70.png" alt="IronPay">
                            </div>
                            <div>
                                <h3>IronPay</h3>
                                <p class="webhook-desc">Webhook específico para IronPay</p>
                            </div>
                        </div>
                        <div class="webhook-url-box">
                            <input type="text" class="webhook-url" value="" data-webhook="webhook-iron.php" readonly>
                            <button class="btn-copy" onclick="copyWebhook(this)">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>

                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <img src="https://files.readme.io/f8bdd9c07f85edda324c037dd88212bc50047f48d0a6c6c0b7ebc6721e3c5733-small-icon.png" alt="Ghost Pays">
                            </div>
                            <div>
                                <h3>Hygros</h3>
                                <p class="webhook-desc">Webhook específico para Hygros</p>
                            </div>
                        </div>
                        <div class="webhook-url-box">
                            <input type="text" class="webhook-url" value="" data-webhook="webhook-ghost.php" readonly>
                            <button class="btn-copy" onclick="copyWebhook(this)">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>

                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjx_WWXra0rlcKE_uF3loJuzc3Evj5G3Tkvw&s" alt="BuckPay">
                            </div>
                            <div>
                                <h3>BuckPay</h3>
                                <p class="webhook-desc">Webhook específico para BuckPay</p>
                            </div>
                        </div>
                        <div class="webhook-url-box">
                            <input type="text" class="webhook-url" value="" data-webhook="webhook-buck.php" readonly>
                            <button class="btn-copy" onclick="copyWebhook(this)">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>

                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <img src="https://storage.googleapis.com/gpt-engineer-file-uploads/Hv82OPNoNiXWe4ZBlPlPGK2yvKS2/uploads/1758545117335-zeroone_favicon.svg" alt="ZeroOnePay">
                            </div>
                            <div>
                                <h3>ZeroOnePay</h3>
                                <p class="webhook-desc">Webhook específico para ZeroOnePay</p>
                            </div>
                        </div>
                        <div class="webhook-url-box">
                            <input type="text" class="webhook-url" value="" data-webhook="webhook-zero.php" readonly>
                            <button class="btn-copy" onclick="copyWebhook(this)">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Config Tab -->
            <div id="configBox" class="tab-content" style="display: none;">
                <div class="config-section">
                    <div class="webhook-info">
                        <h3><i class="fa-solid fa-circle-info"></i> Configurações do Produto</h3>
                        <p>Altere o preço do produto. O nome é opcional e será mantido se não for preenchido.</p>
                    </div>

                    <div class="webhook-card">
                        <div class="webhook-header">
                            <div class="webhook-icon">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                            <div>
                                <h3>Configuração do Produto</h3>
                                <p class="webhook-desc">Defina as informações do produto no checkout</p>
                            </div>
                        </div>
                        <form id="configForm">
                            <div class="form-group">
                                <label for="product_price">Preço (R$)</label>
                                <input type="text" id="product_price" name="product_price" placeholder="21.15" required>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Nome do Produto</label>
                                <input type="text" id="product_name" name="product_name" placeholder="JBL PartyBox Stage 320BR" required>
                            </div>
                            <div class="form-group">
                                <label for="product_description">Descrição do Produto</label>
                                <input type="text" id="product_description" name="product_description" placeholder="A Rainha das Festas Chegou">
                            </div>
                            
                            <div class="form-group">
                                <label>🖼️ Imagem do Produto</label>
                                <div class="image-option">
                                    <div class="image-option-tabs">
                                        <div class="image-tab active" onclick="switchImageTab('product', 'upload')">📤 Upload</div>
                                        <div class="image-tab" onclick="switchImageTab('product', 'url')">🔗 URL</div>
                                    </div>
                                    
                                    <div id="product_image_upload" class="upload-container" onclick="document.getElementById('product_image_file').click()">
                                        <div class="upload-text">
                                            <i class="fa-solid fa-cloud-upload" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                                            Clique para selecionar uma imagem<br>
                                            <small>ou arraste e solte aqui</small>
                                        </div>
                                        <input type="file" id="product_image_file" class="upload-input" accept="image/*" onchange="handleImageUpload(this, 'product')">
                                        <img id="product_image_preview" class="upload-preview" style="display: none;">
                                    </div>
                                    
                                    <div id="product_image_url_container" style="display: none;">
                                        <input type="url" id="product_image" name="product_image" placeholder="https://exemplo.com/imagem.jpg">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="company_name">Nome da Empresa</label>
                                <input type="text" id="company_name" name="company_name" placeholder="Compra Segura">
                            </div>
                            
                            <div class="form-group">
                                <label>🏪 Logo da Empresa</label>
                                <div class="image-option">
                                    <div class="image-option-tabs">
                                        <div class="image-tab active" onclick="switchImageTab('logo', 'upload')">📤 Upload</div>
                                        <div class="image-tab" onclick="switchImageTab('logo', 'url')">🔗 URL</div>
                                    </div>
                                    
                                    <div id="company_logo_upload" class="upload-container" onclick="document.getElementById('company_logo_file').click()">
                                        <div class="upload-text">
                                            <i class="fa-solid fa-cloud-upload" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                                            Clique para selecionar um logo<br>
                                            <small>ou arraste e solte aqui</small>
                                        </div>
                                        <input type="file" id="company_logo_file" class="upload-input" accept="image/*" onchange="handleImageUpload(this, 'logo')">
                                        <img id="company_logo_preview" class="upload-preview" style="display: none;">
                                    </div>
                                    
                                    <div id="company_logo_url_container" style="display: none;">
                                        <input type="url" id="company_logo" name="company_logo" placeholder="https://exemplo.com/logo.png">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save"></i> Salvar Configurações
                            </button>
                        </form>
                        <div id="configLastUpdate" style="margin-top: 16px; color: var(--text-secondary); font-size: 13px;"></div>
                    </div>
                </div>
            </div>

            <!-- Preview Tab -->
            <div id="previewBox" class="tab-content" style="display: none;">
                <div class="preview-container">
                    <div class="preview-controls">
                        <div class="preview-header">
                            <h3 class="preview-title">⚡ Preview em Tempo Real</h3>
                            <div style="display: flex; gap: 8px;">
                                <div style="background: rgba(16, 185, 129, 0.15); color: #34d399; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                    🟢 LIVE
                                </div>
                                <button class="preview-refresh" onclick="refreshPreview()">
                                    <i class="fa-solid fa-refresh"></i>
                                    Recarregar
                                </button>
                            </div>
                        </div>

                        <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: var(--text-secondary);">
                            <strong style="color: #60a5fa;">💡 Como funciona:</strong><br>
                            Digite nos campos abaixo e veja as mudanças aparecerem <strong>instantaneamente</strong> no preview ao lado. Quando estiver satisfeito, clique em "Salvar Alterações" para aplicar definitivamente.
                        </div>

                        <div class="preview-form-group">
                            <label for="preview_product_price">💰 Preço (R$)</label>
                            <input type="text" id="preview_product_price" placeholder="39.90" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                        </div>

                        <div class="preview-form-group">
                            <label for="preview_product_name">📦 Nome do Produto</label>
                            <input type="text" id="preview_product_name" placeholder="JBL PartyBox Stage 320BR" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                        </div>

                        <div class="preview-form-group">
                            <label for="preview_product_description">📝 Descrição</label>
                            <input type="text" id="preview_product_description" placeholder="A Rainha das Festas Chegou" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                        </div>

                        <div class="preview-form-group">
                            <label>🖼️ Imagem do Produto</label>
                            <div class="image-option">
                                <div class="image-option-tabs">
                                    <div class="image-tab active" onclick="switchPreviewImageTab('product', 'upload')">📤 Upload</div>
                                    <div class="image-tab" onclick="switchPreviewImageTab('product', 'url')">🔗 URL</div>
                                </div>
                                
                                <div id="preview_product_image_upload" class="upload-container" onclick="document.getElementById('preview_product_image_file').click()">
                                    <div class="upload-text">
                                        <i class="fa-solid fa-cloud-upload" style="font-size: 20px; margin-bottom: 6px; display: block;"></i>
                                        Clique para selecionar<br>
                                        <small>Mudança em tempo real!</small>
                                    </div>
                                    <input type="file" id="preview_product_image_file" class="upload-input" accept="image/*" onchange="handlePreviewImageUpload(this, 'product')">
                                    <img id="preview_product_image_preview" class="upload-preview" style="display: none;">
                                </div>
                                
                                <div id="preview_product_image_url_container" style="display: none;">
                                    <input type="url" id="preview_product_image" placeholder="https://exemplo.com/imagem.jpg" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                                </div>
                            </div>
                        </div>

                        <div class="preview-form-group">
                            <label for="preview_company_name">🏢 Nome da Empresa</label>
                            <input type="text" id="preview_company_name" placeholder="Compra Segura" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                        </div>

                        <div class="preview-form-group">
                            <label>🏪 Logo da Empresa</label>
                            <div class="image-option">
                                <div class="image-option-tabs">
                                    <div class="image-tab active" onclick="switchPreviewImageTab('logo', 'upload')">📤 Upload</div>
                                    <div class="image-tab" onclick="switchPreviewImageTab('logo', 'url')">🔗 URL</div>
                                </div>
                                
                                <div id="preview_company_logo_upload" class="upload-container" onclick="document.getElementById('preview_company_logo_file').click()">
                                    <div class="upload-text">
                                        <i class="fa-solid fa-cloud-upload" style="font-size: 20px; margin-bottom: 6px; display: block;"></i>
                                        Clique para selecionar<br>
                                        <small>Mudança em tempo real!</small>
                                    </div>
                                    <input type="file" id="preview_company_logo_file" class="upload-input" accept="image/*" onchange="handlePreviewImageUpload(this, 'logo')">
                                    <img id="preview_company_logo_preview" class="upload-preview" style="display: none;">
                                </div>
                                
                                <div id="preview_company_logo_url_container" style="display: none;">
                                    <input type="url" id="preview_company_logo" placeholder="https://exemplo.com/logo.png" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                                </div>
                            </div>
                        </div>

                        <hr style="margin: 32px 0; border-color: var(--border);">

                        <div style="background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <span style="color: var(--primary-light); font-size: 18px;">🎁</span>
                                <strong style="color: var(--primary-light); font-size: 15px;">Gerenciar Ofertas</strong>
                            </div>
                            <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                                Configure as ofertas especiais que aparecerão no checkout. Você pode adicionar até 5 ofertas.
                            </p>
                        </div>

                        <div class="preview-form-group">
                            <label style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" id="preview_offers_visible" onchange="updatePreview()" style="width: 18px; height: 18px; cursor: pointer;">
                                <span>🎁 Mostrar Ofertas no Checkout</span>
                            </label>
                        </div>

                        <div id="preview_offers_container" style="display: none;">
                            <div class="preview-form-group">
                                <label for="preview_offers_count">📊 Quantidade de Ofertas (1-5)</label>
                                <input type="number" id="preview_offers_count" min="1" max="5" value="3" oninput="updateOffersCount()" style="width: 100px;">
                            </div>

                            <div id="preview_offers_list"></div>
                        </div>

                        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; padding: 16px; margin-top: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <span style="color: #34d399; font-size: 16px;">✅</span>
                                <strong style="color: #34d399; font-size: 14px;">Gostou das mudanças?</strong>
                            </div>
                            <p style="color: var(--text-secondary); font-size: 13px; margin: 0 0 12px 0;">
                                Clique no botão abaixo para salvar as configurações e aplicá-las no checkout real.
                            </p>
                            <button class="btn btn-primary" onclick="savePreviewChanges()" style="margin: 0; width: 100%;">
                                <i class="fa-solid fa-save"></i> 💾 Salvar Alterações Definitivamente
                            </button>
                        </div>
                    </div>

                    <div class="preview-iframe-container">
                        <div style="position: absolute; top: 16px; right: 16px; z-index: 10;">
                            <div id="previewStatus" style="background: rgba(16, 185, 129, 0.9); color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; display: none;">
                                ⚡ ATUALIZANDO...
                            </div>
                        </div>
                        <div class="preview-loading" id="previewLoading">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            Carregando preview...
                        </div>
                        <iframe id="previewIframe" class="preview-iframe" style="display: none;"></iframe>
                    </div>
                </div>
            </div>

            <!-- Upsells Tab -->
            <div id="upsellsBox" class="tab-content" style="display: none;">
                <div class="upsells-section">
                    <div class="webhook-info">
                        <h3><i class="fa-solid fa-arrow-trend-up"></i> Gerenciar Ordem dos Upsells</h3>
                        <p>Configure a ordem e valores dos upsells. Arraste para reordenar.</p>
                    </div>

                    <div id="upsellsContainer" style="margin-top: 24px;">
                        <!-- Upsells serão carregados aqui -->
                    </div>

                    <div style="margin-top: 24px;">
                        <button id="saveUpsellsBtn" class="btn btn-primary" style="width: 100%;">
                            <i class="fa-solid fa-save"></i> Salvar Ordem dos Upsells
                        </button>
                    </div>
                </div>
            </div>

            <!-- TikTok Pixels Tab -->
            <div id="tiktokBox" class="tab-content" style="display: none;">
                <div class="tiktok-section">
                    <div class="webhook-info">
                        <h3><i class="fa-brands fa-tiktok"></i> Gerenciar Contas TikTok Pixel</h3>
                        <p>Adicione e gerencie suas contas TikTok Pixel para rastreamento de conversões.</p>
                    </div>

                    <div style="margin-bottom: 24px; text-align: right;">
                        <button id="addTiktokAccountBtn" class="btn btn-primary" style="width: auto; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-plus"></i> Adicionar Conta
                        </button>
                    </div>

                    <div id="tiktokAccountsContainer">
                        <!-- Contas serão carregadas aqui -->
                    </div>

                    <div id="noTiktokAccounts" style="display: none; text-align: center; padding: 48px; color: var(--text-secondary);">
                        <i class="fa-brands fa-tiktok" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                        <p>Nenhuma conta TikTok cadastrada</p>
                        <p style="font-size: 13px; margin-top: 8px;">Clique em "Adicionar Conta" para começar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar/Editar Conta TikTok -->
    <div id="tiktokModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 32px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 24px;">
                <h3 id="tiktokModalTitle" style="color: var(--text-primary); font-size: 20px; font-weight: 600; margin: 0; flex: 1;">Adicionar Conta TikTok</h3>
                <button id="closeTiktokModal" style="background: none; border: none; color: var(--text-secondary); font-size: 24px; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            
            <form id="tiktokForm">
                <input type="hidden" id="tiktokAccountId" name="id">
                
                <div class="form-group">
                    <label for="tiktokAccountName">Nome da Conta</label>
                    <input type="text" id="tiktokAccountName" name="name" placeholder="Ex: Conta Principal" required>
                </div>
                
                <div class="form-group">
                    <label for="tiktokPixelId">Pixel ID</label>
                    <input type="text" id="tiktokPixelId" name="pixel_id" placeholder="Ex: D65U11JC77U1M7M29O2G" required style="font-family: 'Courier New', monospace;">
                </div>
                
                <div class="form-group">
                    <label for="tiktokAccessToken">Access Token</label>
                    <textarea id="tiktokAccessToken" name="access_token" placeholder="Cole aqui seu Access Token" required rows="4"></textarea>
                </div>
                
                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="button" id="cancelTiktokModal" class="btn" style="background: var(--text-secondary); flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fa-solid fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Estado da aplicação
        let isLoggedIn = <?php echo isset($_SESSION['gateway_admin_logged']) ? 'true' : 'false'; ?>;
        let currentGateway = null;
        let currentDomain = window.location.origin + window.location.pathname.replace('/admin-gateway.php', '');

        // Elementos
        const loginBox = document.getElementById('loginBox');
        const adminPanel = document.getElementById('adminPanel');
        const loginForm = document.getElementById('loginForm');
        const logoutBtn = document.getElementById('logoutBtn');
        const alertBox = document.getElementById('alertBox');
        const loadingBox = document.getElementById('loadingBox');
        const gatewayBox = document.getElementById('gatewayBox');
        const webhooksBox = document.getElementById('webhooksBox');
        const configBox = document.getElementById('configBox');
        const lastUpdate = document.getElementById('lastUpdate');
        const gatewayCards = document.querySelectorAll('.gateway-card');
        const tabBtns = document.querySelectorAll('.tab-btn');
        const configForm = document.getElementById('configForm');

        // Inicialização
        init();

        function init() {
            if (isLoggedIn) {
                showAdminPanel();
                loadGatewayConfig();
                loadProductConfig();
                initializeWebhookUrls();
                setupTabs();
                setupConfigForm();
            } else {
                showLoginBox();
            }
        }

        function setupTabs() {
            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetTab = btn.dataset.tab;
                    
                    // Remove active de todos
                    tabBtns.forEach(b => b.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.style.display = 'none';
                    });
                    
                    // Ativa o selecionado
                    btn.classList.add('active');
                    if (targetTab === 'gateways') {
                        gatewayBox.style.display = 'block';
                    } else if (targetTab === 'webhooks') {
                        webhooksBox.style.display = 'block';
                    } else if (targetTab === 'config') {
                        configBox.style.display = 'block';
                    } else if (targetTab === 'preview') {
                        document.getElementById('previewBox').style.display = 'block';
                        initializePreview();
                    } else if (targetTab === 'tiktok') {
                        document.getElementById('tiktokBox').style.display = 'block';
                        loadTiktokAccounts(); // Carregar contas quando a aba for aberta
                    } else if (targetTab === 'upsells') {
                        document.getElementById('upsellsBox').style.display = 'block';
                        loadUpsells(); // Carregar upsells quando a aba for aberta
                    }
                });
            });
        }

        function initializeWebhookUrls() {
            document.querySelectorAll('.webhook-url').forEach(input => {
                const webhookFile = input.dataset.webhook;
                input.value = currentDomain + '/' + webhookFile;
            });
        }

        function copyWebhook(button) {
            const input = button.previousElementSibling;
            input.select();
            input.setSelectionRange(0, 99999); // Para mobile
            
            try {
                navigator.clipboard.writeText(input.value).then(() => {
                    const originalText = button.textContent;
                    button.textContent = '✓ Copiado!';
                    button.classList.add('copied');
                    
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.classList.remove('copied');
                    }, 2000);
                    
                    showAlert('URL do webhook copiada!', 'success');
                }).catch(() => {
                    // Fallback
                    document.execCommand('copy');
                    showAlert('URL do webhook copiada!', 'success');
                });
            } catch (err) {
                showAlert('Erro ao copiar URL', 'error');
            }
        }

        function showLoginBox() {
            loginBox.style.display = 'block';
            adminPanel.style.display = 'none';
        }

        function showAdminPanel() {
            loginBox.style.display = 'none';
            adminPanel.style.display = 'block';
        }

        function showAlert(message, type = 'success') {
            alertBox.textContent = message;
            alertBox.className = `alert alert-${type} show`;
            setTimeout(() => {
                alertBox.classList.remove('show');
            }, 5000);
        }

        // Login
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('gateway-controller.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=login&password=${encodeURIComponent(password)}`
                });

                const data = await response.json();

                if (data.success) {
                    isLoggedIn = true;
                    showAdminPanel();
                    loadGatewayConfig();
                    loadProductConfig();
                    initializeWebhookUrls();
                    setupTabs();
                    setupConfigForm();
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erro ao fazer login', 'error');
            }
        });

        // Logout
        logoutBtn.addEventListener('click', async () => {
            try {
                const response = await fetch('gateway-controller.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=logout'
                });

                const data = await response.json();

                if (data.success) {
                    isLoggedIn = false;
                    showLoginBox();
                }
            } catch (error) {
                showAlert('Erro ao fazer logout', 'error');
            }
        });

        // Carregar configuração
        async function loadGatewayConfig() {
            try {
                const response = await fetch('gateway-controller.php');
                const data = await response.json();

                if (data.success) {
                    currentGateway = data.gateway;
                    updateUI(data.gateway);
                    loadingBox.style.display = 'none';
                    gatewayBox.style.display = 'block';
                }
            } catch (error) {
                showAlert('Erro ao carregar configuração', 'error');
                loadingBox.textContent = 'Erro ao carregar';
            }
        }

        // Atualizar interface
        function updateUI(activeGateway) {
            gatewayCards.forEach(card => {
                const gateway = card.dataset.gateway;
                const statusEl = card.querySelector('.status');
                
                // Remove badge e classe active
                const oldBadge = card.querySelector('.active-badge');
                if (oldBadge) oldBadge.remove();
                card.classList.remove('active');

                if (gateway === activeGateway) {
                    card.classList.add('active');
                    statusEl.textContent = 'Ativo';
                    
                    // Adiciona badge
                    const badge = document.createElement('div');
                    badge.className = 'active-badge';
                    badge.textContent = '✓ Ativo';
                    card.appendChild(badge);
                } else {
                    statusEl.textContent = 'Inativo';
                }
            });
        }

        // Trocar gateway
        gatewayCards.forEach(card => {
            card.addEventListener('click', async () => {
                const gateway = card.dataset.gateway;

                if (gateway === currentGateway) {
                    showAlert('Este gateway já está ativo', 'error');
                    return;
                }

                if (!confirm(`Deseja ativar o gateway ${card.querySelector('h3').textContent}?`)) {
                    return;
                }

                try {
                    const response = await fetch('gateway-controller.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=change_gateway&gateway=${gateway}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        currentGateway = data.gateway;
                        updateUI(data.gateway);
                        showAlert(data.message, 'success');
                    } else {
                        showAlert(data.message, 'error');
                    }
                } catch (error) {
                    showAlert('Erro ao alterar gateway', 'error');
                }
            });
        });

        // Carregar configurações do produto
        async function loadProductConfig() {
            try {
                const response = await fetch('config-controller.php?action=get_config');
                const data = await response.json();

                if (data.success && data.config) {
                    document.getElementById('product_price').value = data.config.product_price || '';
                    document.getElementById('product_name').value = data.config.product_name || '';
                    document.getElementById('product_description').value = data.config.product_description || '';
                    document.getElementById('product_image').value = data.config.product_image || '';
                    document.getElementById('company_name').value = data.config.company_name || '';
                    document.getElementById('company_logo').value = data.config.company_logo || '';
                    
                    if (data.config.last_updated) {
                        document.getElementById('configLastUpdate').textContent = 
                            '✓ Última atualização: ' + new Date(data.config.last_updated).toLocaleString('pt-BR');
                    }
                }
            } catch (error) {
                console.error('Erro ao carregar configurações:', error);
            }
        }

        // Configurar formulário de configurações
        function setupConfigForm() {
            configForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const price = document.getElementById('product_price').value;
                const name = document.getElementById('product_name').value;
                const description = document.getElementById('product_description').value;
                const image = document.getElementById('product_image').value;
                const companyName = document.getElementById('company_name').value;
                const companyLogo = document.getElementById('company_logo').value;

                try {
                    const response = await fetch('config-controller.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=update_config&price=${encodeURIComponent(price)}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}&image=${encodeURIComponent(image)}&company_name=${encodeURIComponent(companyName)}&company_logo=${encodeURIComponent(companyLogo)}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        showAlert(data.message, 'success');
                        if (data.config && data.config.last_updated) {
                            document.getElementById('configLastUpdate').textContent = 
                                '✓ Última atualização: ' + new Date(data.config.last_updated).toLocaleString('pt-BR');
                        }
                    } else {
                        showAlert(data.message, 'error');
                    }
                } catch (error) {
                    showAlert('Erro ao salvar configurações', 'error');
                }
            });
        }

        // ========== FUNÇÕES TIKTOK ==========
        let tiktokAccounts = [];
        let editingTiktokAccountId = null;

        // Elementos TikTok
        const tiktokModal = document.getElementById('tiktokModal');
        const tiktokForm = document.getElementById('tiktokForm');
        const addTiktokAccountBtn = document.getElementById('addTiktokAccountBtn');
        const closeTiktokModalBtn = document.getElementById('closeTiktokModal');
        const cancelTiktokModalBtn = document.getElementById('cancelTiktokModal');

        // Event listeners TikTok
        if (addTiktokAccountBtn) {
            addTiktokAccountBtn.addEventListener('click', showAddTiktokAccountModal);
        }
        if (closeTiktokModalBtn) {
            closeTiktokModalBtn.addEventListener('click', closeTiktokModal);
        }
        if (cancelTiktokModalBtn) {
            cancelTiktokModalBtn.addEventListener('click', closeTiktokModal);
        }
        if (tiktokForm) {
            tiktokForm.addEventListener('submit', saveTiktokAccount);
        }

        // Carregar contas TikTok
        async function loadTiktokAccounts() {
            try {
                const response = await fetch('tiktok-controller.php');
                const data = await response.json();

                if (data.success) {
                    tiktokAccounts = data.accounts || [];
                    renderTiktokAccounts();
                } else {
                    console.error('Erro ao carregar contas TikTok:', data.message);
                    tiktokAccounts = [];
                    renderTiktokAccounts();
                }
            } catch (error) {
                console.error('Erro na requisição TikTok:', error);
                tiktokAccounts = [];
                renderTiktokAccounts();
            }
        }

        // Renderizar contas TikTok
        function renderTiktokAccounts() {
            const container = document.getElementById('tiktokAccountsContainer');
            const noAccountsMsg = document.getElementById('noTiktokAccounts');

            if (tiktokAccounts.length === 0) {
                container.innerHTML = '';
                noAccountsMsg.style.display = 'block';
                return;
            }

            noAccountsMsg.style.display = 'none';

            container.innerHTML = tiktokAccounts.map(account => `
                <div class="webhook-card" style="margin-bottom: 16px;">
                    <div class="webhook-header">
                        <div class="webhook-icon">
                            <i class="fa-brands fa-tiktok" style="color: var(--primary);"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                                <h3>${escapeHtml(account.name)}</h3>
                                <span style="padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; ${account.active ? 'background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3);'}">
                                    ${account.active ? '● ATIVA' : '○ INATIVA'}
                                </span>
                            </div>
                            <p class="webhook-desc">Pixel ID: ${escapeHtml(account.pixel_id)}</p>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button onclick="toggleTiktokAccount(${account.id})" style="background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 8px; border-radius: 6px; transition: all 0.2s;" title="${account.active ? 'Desativar' : 'Ativar'}">
                                <i class="fa-solid fa-power-off"></i>
                            </button>
                            <button onclick="editTiktokAccount(${account.id})" style="background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 8px; border-radius: 6px; transition: all 0.2s;" title="Editar">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button onclick="deleteTiktokAccount(${account.id}, '${escapeHtml(account.name)}')" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 8px; border-radius: 6px; transition: all 0.2s;" title="Remover">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                        <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                            <strong>Access Token:</strong> ${escapeHtml(account.access_token.substring(0, 40))}...
                        </p>
                    </div>
                </div>
            `).join('');
        }

        // Mostrar modal para adicionar conta
        function showAddTiktokAccountModal() {
            editingTiktokAccountId = null;
            document.getElementById('tiktokModalTitle').textContent = 'Adicionar Conta TikTok';
            tiktokForm.reset();
            tiktokModal.style.display = 'flex';
        }

        // Editar conta TikTok
        function editTiktokAccount(id) {
            const account = tiktokAccounts.find(acc => acc.id === id);
            if (!account) return;

            editingTiktokAccountId = id;
            document.getElementById('tiktokModalTitle').textContent = 'Editar Conta TikTok';
            document.getElementById('tiktokAccountId').value = account.id;
            document.getElementById('tiktokAccountName').value = account.name;
            document.getElementById('tiktokPixelId').value = account.pixel_id;
            document.getElementById('tiktokAccessToken').value = account.access_token;
            tiktokModal.style.display = 'flex';
        }

        // Fechar modal TikTok
        function closeTiktokModal() {
            tiktokModal.style.display = 'none';
            tiktokForm.reset();
            editingTiktokAccountId = null;
        }

        // Salvar conta TikTok
        async function saveTiktokAccount(e) {
            e.preventDefault();

            const formData = new FormData(tiktokForm);
            formData.append('action', editingTiktokAccountId ? 'edit_account' : 'add_account');

            try {
                const response = await fetch('tiktok-controller.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    closeTiktokModal();
                    loadTiktokAccounts();
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erro ao salvar conta TikTok', 'error');
            }
        }

        // Alternar status da conta TikTok
        async function toggleTiktokAccount(id) {
            try {
                const formData = new FormData();
                formData.append('action', 'toggle_active');
                formData.append('id', id);

                const response = await fetch('tiktok-controller.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    loadTiktokAccounts();
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erro ao alterar status da conta', 'error');
            }
        }

        // Remover conta TikTok
        async function deleteTiktokAccount(id, name) {
            if (!confirm(`Deseja realmente remover a conta "${name}"?`)) return;

            try {
                const formData = new FormData();
                formData.append('action', 'delete_account');
                formData.append('id', id);

                const response = await fetch('tiktok-controller.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    loadTiktokAccounts();
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erro ao remover conta TikTok', 'error');
            }
        }

        // Função para escapar HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Tornar funções globais para uso nos onclick
        window.editTiktokAccount = editTiktokAccount;
        window.toggleTiktokAccount = toggleTiktokAccount;
        window.deleteTiktokAccount = deleteTiktokAccount;

        // ========== GERENCIAMENTO DE UPSELLS ==========
        let upsellsData = [];

        // Carregar upsells
        async function loadUpsells() {
            try {
                const response = await fetch('upsell-controller.php?action=get_config');
                const data = await response.json();

                if (data.success) {
                    upsellsData = data.config.upsells || [];
                    renderUpsells();
                } else {
                    console.error('Erro ao carregar upsells:', data.message);
                    upsellsData = [];
                    renderUpsells();
                }
            } catch (error) {
                console.error('Erro na requisição de upsells:', error);
                upsellsData = [];
                renderUpsells();
            }
        }

        // Renderizar upsells
        function renderUpsells() {
            const container = document.getElementById('upsellsContainer');

            if (upsellsData.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: var(--text-secondary); padding: 48px;">Nenhum upsell configurado</p>';
                return;
            }

            container.innerHTML = upsellsData.map((upsell, index) => `
                <div class="webhook-card" style="margin-bottom: 16px; cursor: move;" draggable="true" data-index="${index}">
                    <div class="webhook-header">
                        <div class="webhook-icon">
                            <i class="fa-solid fa-grip-vertical" style="color: var(--text-secondary);"></i>
                        </div>
                        <div style="flex: 1;">
                            <h3>${escapeHtml(upsell.name)}</h3>
                            <p class="webhook-desc">ID: ${escapeHtml(upsell.id)} → Próximo: ${escapeHtml(upsell.next)}</p>
                        </div>
                    </div>
                    <div style="margin-top: 16px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                        <div class="form-group" style="margin: 0;">
                            <label style="font-size: 12px; margin-bottom: 4px;">Nome</label>
                            <input type="text" value="${escapeHtml(upsell.name)}" onchange="updateUpsell(${index}, 'name', this.value)" style="padding: 8px 12px; font-size: 13px;">
                        </div>
                        <div class="form-group" style="margin: 0;">
                            <label style="font-size: 12px; margin-bottom: 4px;">Próximo</label>
                            <input type="text" value="${escapeHtml(upsell.next)}" onchange="updateUpsell(${index}, 'next', this.value)" style="padding: 8px 12px; font-size: 13px;">
                        </div>
                        <div class="form-group" style="margin: 0;">
                            <label style="font-size: 12px; margin-bottom: 4px;">Valor (R$)</label>
                            <input type="text" value="${escapeHtml(upsell.value)}" onchange="updateUpsell(${index}, 'value', this.value)" style="padding: 8px 12px; font-size: 13px;">
                        </div>
                    </div>
                </div>
            `).join('');

            // Adicionar eventos de drag and drop
            setupDragAndDrop();
        }

        // Atualizar upsell
        window.updateUpsell = function(index, field, value) {
            if (upsellsData[index]) {
                upsellsData[index][field] = value;
            }
        };

        // Configurar drag and drop
        function setupDragAndDrop() {
            const cards = document.querySelectorAll('#upsellsContainer .webhook-card');
            let draggedElement = null;

            cards.forEach(card => {
                card.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                });

                card.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                });

                card.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    const afterElement = getDragAfterElement(document.getElementById('upsellsContainer'), e.clientY);
                    const container = document.getElementById('upsellsContainer');
                    if (afterElement == null) {
                        container.appendChild(draggedElement);
                    } else {
                        container.insertBefore(draggedElement, afterElement);
                    }
                });
            });
        }

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.webhook-card:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        // Salvar ordem dos upsells
        document.getElementById('saveUpsellsBtn')?.addEventListener('click', async function() {
            const button = this;
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Salvando...';
            button.disabled = true;

            // Coletar ordem atual dos cards
            const cards = document.querySelectorAll('#upsellsContainer .webhook-card');
            const newOrder = [];
            
            cards.forEach(card => {
                const index = parseInt(card.dataset.index);
                if (upsellsData[index]) {
                    newOrder.push(upsellsData[index]);
                }
            });

            try {
                const response = await fetch('upsell-controller.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=update_config&upsells=${encodeURIComponent(JSON.stringify(newOrder))}`
                });

                const data = await response.json();

                if (data.success) {
                    button.innerHTML = '<i class="fa-solid fa-check"></i> Salvo!';
                    button.style.background = 'var(--success)';
                    showAlert(data.message, 'success');
                    
                    upsellsData = newOrder;
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = 'var(--primary)';
                        button.disabled = false;
                    }, 2000);
                } else {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                button.innerHTML = originalText;
                button.disabled = false;
                showAlert('Erro ao salvar ordem dos upsells', 'error');
            }
        });

        // ========== FIM DO GERENCIAMENTO DE UPSELLS ==========

        // ========== GERENCIAMENTO DE OFERTAS NO PREVIEW ==========
        
        // Inicializar controle de ofertas
        const offersVisibleCheckbox = document.getElementById('preview_offers_visible');
        if (offersVisibleCheckbox) {
            offersVisibleCheckbox.addEventListener('change', function() {
                const offersContainer = document.getElementById('preview_offers_container');
                if (offersContainer) {
                    offersContainer.style.display = this.checked ? 'block' : 'none';
                }
                updatePreview();
            });
        }

        // Função para atualizar quantidade de ofertas
        window.updateOffersCount = function() {
            const count = parseInt(document.getElementById('preview_offers_count').value) || 3;
            const offersList = document.getElementById('preview_offers_list');
            
            if (!offersList) return;
            
            // Limpar lista atual
            offersList.innerHTML = '';
            
            // Criar campos para cada oferta
            for (let i = 1; i <= count; i++) {
                const offerHTML = `
                    <div style="background: var(--bg-dark); border: 1px solid var(--border); border-radius: 8px; padding: 16px; margin-bottom: 16px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border);">
                            <span style="color: var(--primary-light); font-weight: 600;">🎁 Oferta ${i}</span>
                        </div>
                        
                        <div class="preview-form-group">
                            <label for="preview_offer_${i}_name">📝 Nome da Oferta</label>
                            <input type="text" id="preview_offer_${i}_name" placeholder="Ex: JBL Battery 400" oninput="updatePreview()">
                        </div>
                        
                        <div class="preview-form-group">
                            <label for="preview_offer_${i}_description">💬 Descrição</label>
                            <input type="text" id="preview_offer_${i}_description" placeholder="Ex: Aproveite esta oferta especial" oninput="updatePreview()">
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div class="preview-form-group">
                                <label for="preview_offer_${i}_old_price">💵 Preço Antigo (R$)</label>
                                <input type="text" id="preview_offer_${i}_old_price" placeholder="35,80" oninput="updatePreview()">
                            </div>
                            
                            <div class="preview-form-group">
                                <label for="preview_offer_${i}_price">💰 Preço Novo (R$)</label>
                                <input type="text" id="preview_offer_${i}_price" placeholder="17,90" oninput="updatePreview()">
                            </div>
                        </div>
                        
                        <div class="preview-form-group">
                            <label>🖼️ Imagem da Oferta</label>
                            <div class="image-option">
                                <div class="image-option-tabs">
                                    <div class="image-tab active" onclick="switchPreviewImageTab('offer_${i}', 'upload')">📤 Upload</div>
                                    <div class="image-tab" onclick="switchPreviewImageTab('offer_${i}', 'url')">🔗 URL</div>
                                </div>
                                
                                <div id="preview_offer_${i}_image_upload" class="upload-container" onclick="document.getElementById('preview_offer_${i}_image_file').click()">
                                    <div class="upload-text">
                                        <i class="fa-solid fa-cloud-upload" style="font-size: 20px; margin-bottom: 6px; display: block;"></i>
                                        Clique para selecionar<br>
                                        <small>Mudança em tempo real!</small>
                                    </div>
                                    <input type="file" id="preview_offer_${i}_image_file" class="upload-input" accept="image/*" onchange="handlePreviewImageUpload(this, 'offer_${i}')">
                                    <img id="preview_offer_${i}_image_preview" class="upload-preview" style="display: none;">
                                </div>
                                
                                <div id="preview_offer_${i}_image_url_container" style="display: none;">
                                    <input type="url" id="preview_offer_${i}_image" placeholder="https://exemplo.com/imagem.jpg" oninput="updatePreview()" onpaste="setTimeout(updatePreview, 10)">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                offersList.innerHTML += offerHTML;
            }
            
            updatePreview();
        };
        
        // Inicializar ofertas com valores padrão
        setTimeout(() => {
            updateOffersCount();
        }, 500);

        // ========== FUNÇÕES DE PREVIEW ==========
        let previewData = {};
        let previewUpdateTimeout = null;

        // Inicializar preview
        function initializePreview() {
            loadPreviewData();
            setupPreviewIframe();
        }

        // Carregar dados atuais para o preview
        async function loadPreviewData() {
            try {
                const response = await fetch('config-controller.php?action=get_config');
                const data = await response.json();

                if (data.success && data.config) {
                    previewData = data.config;
                    
                    // Preencher campos do preview
                    document.getElementById('preview_product_price').value = data.config.product_price || '';
                    document.getElementById('preview_product_name').value = data.config.product_name || '';
                    document.getElementById('preview_product_description').value = data.config.product_description || '';
                    document.getElementById('preview_product_image').value = data.config.product_image || '';
                    document.getElementById('preview_company_name').value = data.config.company_name || '';
                    document.getElementById('preview_company_logo').value = data.config.company_logo || '';
                }
            } catch (error) {
                console.error('Erro ao carregar dados do preview:', error);
            }
        }

        // Configurar iframe do preview
        function setupPreviewIframe() {
            const iframe = document.getElementById('previewIframe');
            const loading = document.getElementById('previewLoading');
            
            // URL do checkout com parâmetro de preview
            const checkoutUrl = '/check/index.html?preview=1';
            
            iframe.onload = function() {
                loading.style.display = 'none';
                iframe.style.display = 'block';
                
                // Aplicar configurações iniciais
                updatePreviewIframe();
            };
            
            iframe.src = checkoutUrl;
        }

        // Atualizar preview em tempo real
        function updatePreview() {
            // Mostrar indicador de atualização
            const statusIndicator = document.getElementById('previewStatus');
            const iframe = document.getElementById('previewIframe');
            
            if (statusIndicator) {
                statusIndicator.style.display = 'block';
            }
            
            if (iframe) {
                iframe.style.opacity = '0.9';
                iframe.style.transition = 'opacity 0.2s ease';
            }
            
            // Cancelar timeout anterior
            if (previewUpdateTimeout) {
                clearTimeout(previewUpdateTimeout);
            }
            
            // Aguardar apenas 100ms antes de atualizar (debounce mais rápido)
            previewUpdateTimeout = setTimeout(() => {
                updatePreviewIframe();
                
                // Esconder indicador após atualização
                setTimeout(() => {
                    if (statusIndicator) {
                        statusIndicator.style.display = 'none';
                    }
                    if (iframe) {
                        iframe.style.opacity = '1';
                    }
                }, 300);
            }, 100);
        }

        // Atualizar iframe do preview
        function updatePreviewIframe() {
            const iframe = document.getElementById('previewIframe');
            
            if (!iframe.contentWindow) return;
            
            try {
                // Coletar dados dos campos
                const newData = {
                    product_price: document.getElementById('preview_product_price').value || previewData.product_price,
                    product_name: document.getElementById('preview_product_name').value || previewData.product_name,
                    product_description: document.getElementById('preview_product_description').value || previewData.product_description,
                    product_image: document.getElementById('preview_product_image').value || previewData.product_image,
                    company_name: document.getElementById('preview_company_name').value || previewData.company_name,
                    company_logo: document.getElementById('preview_company_logo').value || previewData.company_logo
                };
                
                // Coletar dados das ofertas
                const offersVisible = document.getElementById('preview_offers_visible')?.checked || false;
                const offersCount = parseInt(document.getElementById('preview_offers_count')?.value) || 0;
                const offers = [];
                
                if (offersVisible && offersCount > 0) {
                    for (let i = 1; i <= offersCount; i++) {
                        const name = document.getElementById(`preview_offer_${i}_name`)?.value || '';
                        const description = document.getElementById(`preview_offer_${i}_description`)?.value || '';
                        const oldPrice = document.getElementById(`preview_offer_${i}_old_price`)?.value || '';
                        const price = document.getElementById(`preview_offer_${i}_price`)?.value || '';
                        
                        // Verificar se está usando upload ou URL
                        const uploadContainer = document.getElementById(`preview_offer_${i}_image_upload`);
                        const urlContainer = document.getElementById(`preview_offer_${i}_image_url_container`);
                        let image = '';
                        
                        if (uploadContainer && uploadContainer.style.display !== 'none') {
                            // Usando upload - pegar da preview
                            const previewImg = document.getElementById(`preview_offer_${i}_image_preview`);
                            if (previewImg && previewImg.style.display !== 'none') {
                                image = previewImg.src;
                            }
                        } else if (urlContainer && urlContainer.style.display !== 'none') {
                            // Usando URL
                            image = document.getElementById(`preview_offer_${i}_image`)?.value || '';
                        }
                        
                        if (name || description || price) {
                            offers.push({
                                name: name,
                                description: description,
                                oldPrice: oldPrice,
                                price: price,
                                image: image
                            });
                        }
                    }
                }
                
                newData.offers = {
                    visible: offersVisible,
                    items: offers
                };
                
                // Enviar dados para o iframe
                iframe.contentWindow.postMessage({
                    type: 'updatePreview',
                    data: newData
                }, '*');
                
            } catch (error) {
                console.error('Erro ao atualizar preview:', error);
            }
        }

        // Atualizar preview (função global)
        window.updatePreview = updatePreview;

        // Refresh do preview
        window.refreshPreview = function() {
            const iframe = document.getElementById('previewIframe');
            const loading = document.getElementById('previewLoading');
            
            loading.style.display = 'flex';
            iframe.style.display = 'none';
            
            iframe.src = iframe.src; // Recarregar iframe
        };

        // Salvar alterações do preview
        window.savePreviewChanges = async function() {
            const saveButton = event.target;
            const originalText = saveButton.innerHTML;
            
            // Mostrar loading no botão
            saveButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Salvando...';
            saveButton.disabled = true;
            
            const price = document.getElementById('preview_product_price').value;
            const name = document.getElementById('preview_product_name').value;
            const description = document.getElementById('preview_product_description').value;
            const image = document.getElementById('preview_product_image').value;
            const companyName = document.getElementById('preview_company_name').value;
            const companyLogo = document.getElementById('preview_company_logo').value;
            
            // Coletar dados das ofertas
            const offersVisible = document.getElementById('preview_offers_visible')?.checked || false;
            const offersCount = parseInt(document.getElementById('preview_offers_count')?.value) || 0;
            const offers = [];
            
            if (offersVisible && offersCount > 0) {
                for (let i = 1; i <= offersCount; i++) {
                    const name = document.getElementById(`preview_offer_${i}_name`)?.value || '';
                    const description = document.getElementById(`preview_offer_${i}_description`)?.value || '';
                    const oldPrice = document.getElementById(`preview_offer_${i}_old_price`)?.value || '';
                    const price = document.getElementById(`preview_offer_${i}_price`)?.value || '';
                    
                    // Verificar se está usando upload ou URL
                    const uploadContainer = document.getElementById(`preview_offer_${i}_image_upload`);
                    const urlContainer = document.getElementById(`preview_offer_${i}_image_url_container`);
                    let image = '';
                    
                    if (uploadContainer && uploadContainer.style.display !== 'none') {
                        const previewImg = document.getElementById(`preview_offer_${i}_image_preview`);
                        if (previewImg && previewImg.style.display !== 'none') {
                            image = previewImg.src;
                        }
                    } else if (urlContainer && urlContainer.style.display !== 'none') {
                        image = document.getElementById(`preview_offer_${i}_image`)?.value || '';
                    }
                    
                    if (name || description || price) {
                        offers.push({
                            name: name,
                            description: description,
                            oldPrice: oldPrice,
                            price: price,
                            image: image
                        });
                    }
                }
            }
            
            const offersData = {
                visible: offersVisible,
                items: offers
            };

            try {
                const response = await fetch('config-controller.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=update_config&price=${encodeURIComponent(price)}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}&image=${encodeURIComponent(image)}&company_name=${encodeURIComponent(companyName)}&company_logo=${encodeURIComponent(companyLogo)}&offers=${encodeURIComponent(JSON.stringify(offersData))}`
                });

                const data = await response.json();

                if (data.success) {
                    // Feedback visual de sucesso
                    saveButton.innerHTML = '<i class="fa-solid fa-check"></i> ✅ Salvo com Sucesso!';
                    saveButton.style.background = 'var(--success)';
                    
                    showAlert('🎉 Configurações salvas com sucesso! O checkout foi atualizado.', 'success');
                    
                    // Atualizar dados locais
                    previewData = data.config;
                    
                    // Atualizar campos da aba de configurações também
                    document.getElementById('product_price').value = data.config.product_price || '';
                    document.getElementById('product_name').value = data.config.product_name || '';
                    document.getElementById('product_description').value = data.config.product_description || '';
                    document.getElementById('product_image').value = data.config.product_image || '';
                    document.getElementById('company_name').value = data.config.company_name || '';
                    document.getElementById('company_logo').value = data.config.company_logo || '';
                    
                    // Restaurar botão após 3 segundos
                    setTimeout(() => {
                        saveButton.innerHTML = originalText;
                        saveButton.style.background = 'var(--primary)';
                        saveButton.disabled = false;
                    }, 3000);
                    
                } else {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                saveButton.innerHTML = originalText;
                saveButton.disabled = false;
                showAlert('Erro ao salvar configurações', 'error');
            }
        };

        // ========== FUNÇÕES DE UPLOAD DE IMAGEM ==========
        
        // Alternar entre upload e URL
        window.switchImageTab = function(type, mode) {
            const uploadContainer = document.getElementById(`${type === 'product' ? 'product_image' : 'company_logo'}_upload`);
            const urlContainer = document.getElementById(`${type === 'product' ? 'product_image' : 'company_logo'}_url_container`);
            const tabs = event.target.parentElement.querySelectorAll('.image-tab');
            
            // Atualizar tabs
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            if (mode === 'upload') {
                uploadContainer.style.display = 'block';
                urlContainer.style.display = 'none';
            } else {
                uploadContainer.style.display = 'none';
                urlContainer.style.display = 'block';
            }
        };

        // Alternar entre upload e URL no preview
        window.switchPreviewImageTab = function(type, mode) {
            // Determinar IDs baseado no tipo
            let uploadContainerId, urlContainerId;
            
            if (type === 'product') {
                uploadContainerId = 'preview_product_image_upload';
                urlContainerId = 'preview_product_image_url_container';
            } else if (type === 'logo') {
                uploadContainerId = 'preview_company_logo_upload';
                urlContainerId = 'preview_company_logo_url_container';
            } else if (type.startsWith('offer_')) {
                // Para ofertas: type = 'offer_1', 'offer_2', etc
                uploadContainerId = `preview_${type}_image_upload`;
                urlContainerId = `preview_${type}_image_url_container`;
            }
            
            const uploadContainer = document.getElementById(uploadContainerId);
            const urlContainer = document.getElementById(urlContainerId);
            const tabs = event.target.parentElement.querySelectorAll('.image-tab');
            
            // Atualizar tabs
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            if (mode === 'upload') {
                if (uploadContainer) uploadContainer.style.display = 'block';
                if (urlContainer) urlContainer.style.display = 'none';
            } else {
                if (uploadContainer) uploadContainer.style.display = 'none';
                if (urlContainer) urlContainer.style.display = 'block';
            }
        };

        // Upload de imagem (configurações)
        window.handleImageUpload = async function(input, type) {
            const file = input.files[0];
            if (!file) return;

            // Validar tipo de arquivo
            if (!file.type.startsWith('image/')) {
                showAlert('Por favor, selecione apenas arquivos de imagem', 'error');
                return;
            }

            // Validar tamanho (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('Arquivo muito grande. Máximo: 5MB', 'error');
                return;
            }

            // Mostrar preview local
            const preview = document.getElementById(`${type === 'product' ? 'product_image' : 'company_logo'}_preview`);
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);

            // Upload para servidor
            const formData = new FormData();
            formData.append('image', file);

            try {
                showAlert('Enviando imagem...', 'success');
                
                const response = await fetch('upload-handler.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Atualizar campo URL correspondente
                    const urlInput = document.getElementById(type === 'product' ? 'product_image' : 'company_logo');
                    urlInput.value = data.url;
                    
                    showAlert('✅ Imagem enviada com sucesso!', 'success');
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erro ao enviar imagem', 'error');
                console.error('Erro no upload:', error);
            }
        };

        // Upload de imagem (preview)
        window.handlePreviewImageUpload = async function(input, type) {
            const file = input.files[0];
            if (!file) return;

            // Validar tipo de arquivo
            if (!file.type.startsWith('image/')) {
                showAlert('Por favor, selecione apenas arquivos de imagem', 'error');
                return;
            }

            // Validar tamanho (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('Arquivo muito grande. Máximo: 5MB', 'error');
                return;
            }

            // Determinar IDs baseado no tipo
            let previewId, urlInputId, dataKey;
            
            if (type === 'product') {
                previewId = 'preview_product_image_preview';
                urlInputId = 'preview_product_image';
                dataKey = 'product_image';
            } else if (type === 'logo') {
                previewId = 'preview_company_logo_preview';
                urlInputId = 'preview_company_logo';
                dataKey = 'company_logo';
            } else if (type.startsWith('offer_')) {
                // Para ofertas: type = 'offer_1', 'offer_2', etc
                previewId = `preview_${type}_image_preview`;
                urlInputId = `preview_${type}_image`;
                dataKey = `${type}_image`;
            }

            // Mostrar preview local imediatamente
            const preview = document.getElementById(previewId);
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                // Atualizar preview em tempo real com a imagem local
                updatePreview();
            };
            reader.readAsDataURL(file);

            // Upload para servidor em background
            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('upload-handler.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Atualizar com URL do servidor
                    const urlInput = document.getElementById(urlInputId);
                    if (urlInput) {
                        urlInput.value = data.url;
                    }
                    
                    // Atualizar preview com URL final
                    setTimeout(() => {
                        updatePreview();
                    }, 500);
                    
                    console.log('✅ Upload concluído:', data.url);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                console.error('Erro no upload:', error);
                showAlert('Erro ao fazer upload da imagem', 'error');
            }
        };

        // Drag and drop para upload containers
        document.addEventListener('DOMContentLoaded', function() {
            const uploadContainers = document.querySelectorAll('.upload-container');
            
            uploadContainers.forEach(container => {
                container.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });
                
                container.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });
                
                container.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const input = this.querySelector('input[type="file"]');
                        input.files = files;
                        
                        // Disparar evento de mudança
                        const event = new Event('change', { bubbles: true });
                        input.dispatchEvent(event);
                    }
                });
            });
        });
        ;
    </script>
</body>
</html>
