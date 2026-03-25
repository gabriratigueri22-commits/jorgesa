import urllib.request
import json

API_BASE = 'https://api.syncpayments.com.br'
CLIENT_ID = '3ba8c2e7-4421-4ecc-9b1b-4d40f5c33036'
CLIENT_SECRET = 'e5383090-b742-4580-87fb-50efcbe5425e'

print('[AUTH] Pedindo token...')
auth_data = json.dumps({"client_id": CLIENT_ID, "client_secret": CLIENT_SECRET}).encode('utf-8')
req_auth = urllib.request.Request(API_BASE + '/api/partner/v1/auth-token', data=auth_data, headers={'Content-Type': 'application/json'}, method='POST')

try:
    with urllib.request.urlopen(req_auth) as response:
        auth_status = response.status
        auth_body = response.read().decode('utf-8')
        print(f"[AUTH] Status: {auth_status} | Body: {auth_body[:200]}")
        token_data = json.loads(auth_body)
        token = token_data.get('access_token') or token_data.get('token')
        print(f"[AUTH] ✅ Token: {token[:25]}...")

        payload = {
            "amount": 69.47,
            "description": "Taxa de Saque SVR - Valores a Receber",
            "client": {
                "name": "Contribuinte SVR Teste",
                "cpf": "11122233344",
                "email": "contribuinte@gov.br",
                "phone": "11999999999"
            }
        }
        
        print('\n[PIX] Gerando cobrança (cash-in)...')
        print(f"[PIX] Payload: {json.dumps(payload)}")
        pix_data_bytes = json.dumps(payload).encode('utf-8')
        
        req_pix = urllib.request.Request(API_BASE + '/api/partner/v1/cash-in', data=pix_data_bytes, headers={
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': f'Bearer {token}'
        }, method='POST')
        
        try:
            with urllib.request.urlopen(req_pix) as response_pix:
                pix_status = response_pix.status
                pix_body = response_pix.read().decode('utf-8')
                print(f"[PIX] Status: {pix_status} | Body: {pix_body}")
        except urllib.error.HTTPError as e:
            err_body = e.read().decode('utf-8')
            print(f"[PIX ERRO] Status: {e.code} | Body: {err_body}")

except urllib.error.HTTPError as e:
    err_body = e.read().decode('utf-8')
    print(f"[AUTH ERRO] Status: {e.code} | Body: {err_body}")
