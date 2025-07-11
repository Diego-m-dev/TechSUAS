const express = require('express');
const http = require('http');
const WebSocket = require('ws');
const cors = require('cors');

const PORT = process.env.PORT || 8080;

const app = express();
const server = http.createServer(app);

// ✅ Habilita CORS apenas para o domínio do seu sistema
app.use(cors({
  origin: 'https://techsuas.com'
}));

// ✅ Middleware para JSON
app.use(express.json());

// ✅ Servidor WebSocket no caminho /ws
const wss = new WebSocket.Server({ server, path: '/ws' });

// Lista de conexões ativas
let conexoes = [];

wss.on('connection', (ws) => {
  conexoes.push(ws);
  console.log('📡 Cliente conectado');

  ws.on('close', () => {
    conexoes = conexoes.filter(c => c !== ws);
    console.log('❌ Cliente desconectado');
  });
});

// ✅ Rota de API para enviar senha ao painel
app.post('/enviar', (req, res) => {
  const dados = req.body;

  if (!dados.senha || !dados.guiche) {
    return res.status(400).send('Dados incompletos');
  }

  const json = JSON.stringify(dados);
  conexoes.forEach(ws => {
    if (ws.readyState === WebSocket.OPEN) {
      ws.send(json);
    }
  });

  console.log('📨 Nova senha enviada:', dados);
  res.send('Enviado com sucesso!');
});

// ✅ Rota de teste
app.get('/', (_, res) => {
  res.send('Servidor WebSocket do Painel está ativo.');
});

// ✅ Inicia o servidor
server.listen(PORT, () => {
  console.log(`✅ Servidor rodando na porta ${PORT}`);
})