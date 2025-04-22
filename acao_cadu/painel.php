<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stylePainel.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png" />
    <title>Painel de Chamadas</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="function.js"></script>

</head>
<body>
  <div class="container">

    <div class="topo"> 
      <h1>Senha Atual:<div id="senhaAtual">---</div> <div id="guiche">--</div>
      </h1>
    </div> <!-- topo -->
  <div class="conteudo">
    <div class="esquerdo">
    <div id="videoYoutube"></div>
    </div> <!-- esquerdo -->

    <div class="direito"> 
      <div class="lista-anteriores">
        <h2>Últimas chamadas:</h2>
        <div id="anteriores"></div>
      </div> <!-- Fim da div lista-anteriores -->
    </div> <!-- Fim da div direito -->
</div> <!-- Fim da div conteudo -->
  </div> <!-- Fecha a div conteiner -->
    <script>
let somPermitido = false;
let player

document.addEventListener('click', () => {
  somPermitido = true;
  if (player && typeof player.unMute === 'function') {
    player.unMute()
    player.setVolume(100)
  }
})

// Carrega API do YouTube
const tag = document.createElement('script')
tag.src = "https://www.youtube.com/iframe_api"
const firstScriptTag = document.getElementsByTagName('script')[0]
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)

// Quando a API estiver pronta, cria o player
function onYouTubeIframeAPIReady() {
  const videoId = localStorage.getItem('videoYoutubeID') || 'MylQJmtrl6k'

  player = new YT.Player('videoYoutube', {
    height: '315',
    width: '100%',
    videoId: videoId,
    playerVars: {
      autoplay: 1,
      controls: 0,
      modestbranding: 1,
      showinfo: 0,
      rel: 0
    },
    events: {
      onReady: (event) => {
        event.target.mute()
        event.target.playVideo()
      }
    }
  })
}

const socket = new WebSocket('ws://localhost:8080');

socket.onopen = () => {
  console.log("✅ Conectado ao servidor WebSocket");
};

socket.onmessage = async (event) => {
  const textData = await event.data.text();
  const dados = JSON.parse(textData);



  console.log("📨 Nova senha recebida:", dados);

  const senhaAtual = document.getElementById('senhaAtual')
  const guicheA = document.getElementById('guiche')



    // Baixa o volume do vídeo ao chamar senha
    if (player && typeof player.setVolume === 'function') {
    player.setVolume(10); // Reduz volume para 10%
    }

  // 🎯 Atualiza a senha e guichê na tela
  senhaAtual.textContent = dados.senha;
  guicheA.textContent = 'Guichê ' + dados.guiche;

  // 🔔 Toca som de notificação, se permitido
  if (somPermitido) {
    const audio = new Audio('som/ding.mp3');
    audio.play().catch((e) => console.warn("Som bloqueado:", e));
  }

  // ✨ Efeito visual (destaque com piscada)
  senhaAtual.classList.add('piscando');
  setTimeout(() => senhaAtual.classList.remove('piscando'), 3000);

  // 🔊 Fala a senha
  let texto = `ATENÇÃO! senha ${dados.senha}`;
  if (dados.nome) {
    const nomeLimpo = dados.nome.replace(/<[^>]*>?/gm, '').replace(/ +/g, ' ').trim();
    texto += `, ${nomeLimpo}`;
  }
  if (dados.guiche) {
    texto += `, atendimento no guichê ${dados.guiche}`;
  }

  const msg = new SpeechSynthesisUtterance(texto);
  msg.lang = 'pt-BR';
  msg.rate = 0.9;
  speechSynthesis.speak(msg);

  atualizarPainel()

  setTimeout(() => {
    if (player && typeof player.setVolume === 'function') {
      player.setVolume(100)
    }
  }, 15000);

}

// Atualiza a lista de chamadas anteriores
function atualizarPainel() {
  fetch('/TechSUAS/acao_cadu/get_chamadas.php')
    .then(res => res.json())
    .then(dados => {
      if (dados.length > 0) {
        const anteriores = dados.slice(1).map(s => {
          return `<div class="item-anterior">${s.senha} - ${s.programa} (${s.tipo})</div>`
        }).join('');
        document.getElementById('anteriores').innerHTML = anteriores
      }
    })
}

</script>
</body>
</html>
