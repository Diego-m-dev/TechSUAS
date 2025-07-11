const express = require('express')
const http = require('http')
const WebSocket = require('ws')

const PORT = process.env.PORT || 8080
const app = express()
const server = http.createServer(app)
const wss = new WebSocket.Server({ server, path: "/ws" });

let conexoes = []

wss.on('connection', (ws) => {
  conexoes.push(ws)
  console.log('📡 Cliente conectado')

  ws.on('close', () => {
    conexoes = conexoes.filter(c => c !== ws)
    console.log('❌ Cliente desconectado')
  });
});

app.use(express.json())

// Rota para enviar nova senha
app.post('/enviar', (req, res) => {
  const dados = req.body

  if (!dados.senha || !dados.guiche) {
    return res.status(400).send('Dados incompletos')
  }

  const json = JSON.stringify(dados)
  conexoes.forEach(ws => ws.send(json))

  console.log('📨 Nova senha enviada:', dados)
  res.send('Enviado!')
})

// Teste se o servidor está rodando
app.get('/', (_, res) => {
  res.send('Servidor WebSocket do Painel está ativo.')
})

server.listen(PORT, () => {
  console.log(`✅ Servidor rodando na porta ${PORT}`)
})