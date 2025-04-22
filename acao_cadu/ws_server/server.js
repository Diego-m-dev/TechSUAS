const WebSocket = require('ws')

// Railway define a porta no ambiente, senão usa 8080 localmente
const PORT = process.env.PORT || 8080
const wss = new WebSocket.Server({ port: PORT })

console.log(`Servidor WebSocket escutando na porta ${PORT}`)

wss.on('connection', socket => {
    console.log('🔌 Novo painel conectado')

    socket.on('message', msg => {
        console.log(`📢 Mensagem recebida: ${msg}`)

        // envia para todos conectados
        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(msg)
            }
        })
    })
})