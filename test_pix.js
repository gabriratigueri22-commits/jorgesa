const API_BASE = 'https://api.syncpayments.com.br';
const CLIENT_ID = '3ba8c2e7-4421-4ecc-9b1b-4d40f5c33036';
const CLIENT_SECRET = 'e5383090-b742-4580-87fb-50efcbe5425e';

async function testApi() {
    try {
        console.log('[AUTH] Pedindo token...');
        const tokenRes = await fetch(API_BASE + '/api/partner/v1/auth-token', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ client_id: CLIENT_ID, client_secret: CLIENT_SECRET })
        });
        
        const tokenText = await tokenRes.text();
        console.log('[AUTH] Status:', tokenRes.status, '| Body:', tokenText.substring(0,200));
        
        if (!tokenRes.ok) throw new Error('Token falhou');
        
        const tokenData = JSON.parse(tokenText);
        const accessToken = tokenData.access_token || tokenData.token;
        console.log('[AUTH] ✅ Token:', accessToken.substring(0, 25) + '...');

        console.log('\n[PIX] Gerando cobrança (cash-in)...');
        const payload = {
            amount: 69.47,
            description: 'Taxa de Saque SVR - Valores a Receber',
            client: {
                name: 'Contribuinte SVR Teste',
                cpf: '11122233344',
                email: 'contribuinte@gov.br',
                phone: '11999999999'
            }
        };
        console.log('[PIX] Payload:', JSON.stringify(payload));

        const pixRes = await fetch(API_BASE + '/api/partner/v1/cash-in', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + accessToken
            },
            body: JSON.stringify(payload)
        });

        const pixText = await pixRes.text();
        console.log('[PIX] Status:', pixRes.status, '| Body:', pixText);
        
    } catch (e) {
        console.error('[ERRO]', e.message);
    }
}

testApi();
