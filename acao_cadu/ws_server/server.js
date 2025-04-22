// server.js

const WebSocket = require('ws')
const wss = new WebSocket.Server({ port: 8080 })

console.log("Servidor WebSocket escutando na porta 8080")

wss.on('connection', socket => {
    console.log('🔌 Novo painel conectado')

    socket.on('message', msg => {
        console.log(`📢 Mensagem recebida: ${msg}`)

        // envia a mensagem para todos os paineis conectados
        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(msg)
            }
        })
    })
})