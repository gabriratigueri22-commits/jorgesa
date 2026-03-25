export default async function handler(req, res) {
  // Configuração dos headers para permitir CORS localmente enquanto desenvolvem e rodam em Python
  res.setHeader('Access-Control-Allow-Credentials', true);
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET,OPTIONS,PATCH,DELETE,POST,PUT');
  res.setHeader('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version, Authorization');

  // Trata requisições OPTIONS (Pre-flight do CORS no navegador)
  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Apenas requisições POST permitidas' });
  }

  const API_BASE = 'https://api.syncpayments.com.br';
  const CLIENT_ID = '3ba8c2e7-4421-4ecc-9b1b-4d40f5c33036';
  const CLIENT_SECRET = 'e5383090-b742-4580-87fb-50efcbe5425e';

  try {
    console.log('[BACKEND AUTH] Solicitando token...');
    // ===== PASSO 1: Obter Token da SyncPayments =====
    const tokenRes = await fetch(`${API_BASE}/api/partner/v1/auth-token`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ client_id: CLIENT_ID, client_secret: CLIENT_SECRET })
    });

    const tokenText = await tokenRes.text();
    if (!tokenRes.ok) {
        console.error('[AUTH ERRO]', tokenText);
        return res.status(tokenRes.status).json({ step: 'auth', error: tokenText });
    }

    const tokenData = JSON.parse(tokenText);
    const accessToken = tokenData.access_token || tokenData.token || (tokenData.data && (tokenData.data.access_token || tokenData.data.token));
    
    if (!accessToken) {
        return res.status(500).json({ step: 'auth', error: 'Token não mapeado no JSON', text: tokenText });
    }

    console.log('[BACKEND PIX] Gerando Cash-in...');
    // ===== PASSO 2: Montar CashIn PIX com o Bearer JWT =====
    const payload = req.body;
    
    const pixRes = await fetch(`${API_BASE}/api/partner/v1/cash-in`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${accessToken}`
        },
        body: JSON.stringify(payload) // Repassado perfeitamente do frontend (já validado)
    });

    const pixText = await pixRes.text();
    
    if (!pixRes.ok) {
        console.error('[CASH-IN ERRO]', pixRes.status, pixText);
        return res.status(pixRes.status).json({ step: 'cashin', error: pixText });
    }

    // Sucesso - Encaminha resposta íntegra ao Frontend
    console.log('[BACKEND PIX] ✅ Criado Sucesso');
    return res.status(200).json(JSON.parse(pixText));

  } catch (error) {
    console.error('[API INTERNAL ERROR]', error);
    return res.status(500).json({ error: error.message, stack: error.stack });
  }
}
