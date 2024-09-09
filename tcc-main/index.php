<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta content="" name="keywords" />

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/header_footer.css" />
  <link rel="stylesheet" href="css/diario.css" />
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  <title>TCC</title>

  <!-- Incluindo a biblioteca Ionicons -->
  <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <script>
    async function getWeatherData(lat, lon) {
      try {
        const weatherResponse = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum,weathercode&timezone=auto&lang=pt`);

        const weatherData = await weatherResponse.json();

        if (weatherResponse.status !== 200) {
          throw new Error(weatherData.error.message);
        }

        let forecastContainer = document.getElementById('previsao_container');
        forecastContainer.innerHTML = ''; // Limpa o conteúdo anterior


        // Obter o dia atual
        const today = new Date();

        // Limitar a exibição para 3 dias
        for (let index = 0; index < 3; index++) {
          // Calcular a data para cada dia da previsão
          const date = new Date(today);
          date.setDate(today.getDate() + index);

          let weatherCode = weatherData.daily.weathercode[index]; // Código do clima
          let forecastDay = document.createElement('div');
          forecastDay.className = 'forecast_day';

          // Determine o ícone com base no código do clima
          let icon;
          switch (weatherCode) {
            case 0:
              icon = '<ion-icon name="sunny-outline"></ion-icon>'; // Ensolarado
              break;
            case 1:
            case 2:
              icon = '<ion-icon name="partly-sunny-outline"></ion-icon>'; // Parcialmente Nublado
              break;
            case 3:
            case 4:
              icon = '<ion-icon name="cloud-outline"></ion-icon>'; // Nublado
              break;
            case 5:
            case 6:
            case 7:
              icon = '<ion-icon name="rainy-outline"></ion-icon>'; // Chuvoso
              break;
            case 8:
              icon = '<ion-icon name="thunderstorm-outline"></ion-icon>'; // Tempestade
              break;
            case 9:
              icon = '<ion-icon name="snow-outline"></ion-icon>'; // Frio
              break;
            default:
              icon = '<ion-icon name="help-outline"></ion-icon>'; // Ícone padrão para condições desconhecidas
              break;
          }

          forecastDay.innerHTML = `
            <div class="dia">
              <div class="data">${date.toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'short' })}</div>
              <div class="icon_thermal" style="font-size: 48px;">${icon}</div>
              <div class="temperaturas">
                <div>Máx: ${Math.round(weatherData.daily.temperature_2m_max[index])}°C</div>
                <div>Mín: ${Math.round(weatherData.daily.temperature_2m_min[index])}°C</div>
                <div>Precipitação: ${weatherData.daily.precipitation_sum[index]} mm</div>
              </div>
            </div>
          `;
          forecastContainer.appendChild(forecastDay);
        }

        // Chamar função para mudar o fundo com base na hora do dia
        changeBackgroundByTime();

      } catch (error) {
        console.error('Erro ao obter dados do tempo:', error);
      }
    }

    function changeBackground(weatherCode) {
      let body = document.body;
      switch (weatherCode) {
        case 0: // Ensolarado
          body.style.backgroundImage = "url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0')";
          break;
        case 1:
        case 2: // Parcialmente nublado
          body.style.backgroundImage = "url('https://images.unsplash.com/photo-1529302553-c1f2046e18e2')";
          break;
        case 3: // Chuvoso
        case 4: // Tempestade
          body.style.backgroundImage = "url('https://images.unsplash.com/photo-1523952376383-90c1e86c65cf')";
          break;
        case 5: // Frio
          body.style.backgroundImage = "url('https://images.unsplash.com/photo-1519648028840-4d828b2a747c')";
          break;
        default:
          body.style.backgroundImage = "url('https://images.unsplash.com/photo-1593642632823-e168bda3d6f1')"; // Fundo padrão
          break;
      }

      // Propriedades para adaptar a imagem de fundo

    }


    // Chamando a função para obter os dados do tempo
    getWeatherData(-21.248833, -50.314750); // Substitua pelas coordenadas reais
  </script>
  <section class="popup">
    <!--Pix-->
    <div class="popup_container" id="popup_container-pix">
      <div class="container_pix">
        <div class="pix_texto">
          <button class="fechar" id="close">&times;</button>
          <h2>OLHA O PIX</h2>
          <p>Nos apoie, aceitamos doação de qualquer valor</p>
        </div>
        <img src="img/pix.png" alt="" />
      </div>
    </div>
    <!--cadastro-->
    <div class="popup_container" id="popup_container-cadastro">
      <div class="container_cadastro">
        <div class="pix_texto">
          <button class="fechar" id="close2">&times;</button>
          <h2>Cadastre-se e Receba Atualizações</h2>
        </div>
        <fieldset class="fieldset_form">
          <form action="" method="post" class="form_cadastro" onsubmit="enviarFormulario(event);">
            <div class="form-group">
              <ion-icon name="person-circle-outline"></ion-icon>
              <input type="text" name="nome_usuario" id="nome_usuario" required>
              <label for="nome">Nome Completo</label>
            </div>
            <div class="form-group">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="email" name="email" id="email" required>
              <label for="email">Email</label>
            </div>
            <div class="form-group">
              <ion-icon name="call-outline"></ion-icon>
              <input type="text" name="telefone" id="telefone" required>
              <label for="telefone">Telefone</label>
            </div>
            <input type="submit" class="btn" value="Enviar"></input>
            
          </form>
          <div id="mensagem" ></div>
        </fieldset>
        
      </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </section>
  <div class="container">
    <header>
      <div class="logo">
        <h1>ECO</h1>
      </div>
    </header>
    <main>
      <div class="container_main_principal">
        <!--section informação relogio-->
        <section id="info_diaria">
          <div id="barra_lateral"></div>
          <div id="conteudo_diario">
            <div id="umidade">
              <p>umildade: 50%</p>
            </div>
            <div id="time"></div>
            <div id="conteudo_menor">
              <div id="date"></div>
              <div id="day"></div>
              <div id="temperatura">35°C</div>
            </div>
          </div>
        </section>
        <!--section informação diaria-->
        <section id="diario">
          <div class="section_dia">
            <div class="dia_titulo">
              <div class="icon_calendar">
                <ion-icon name="calendar-outline"></ion-icon>
              </div>
              <h2>Previsão para 3 dias</h2>
            </div>
          </div>
          <!-- O conteúdo da previsão será inserido aqui -->
          <div id="previsao_container"></div>
        </section>
        <section id="sec_btn_dados">
          <button id="b_dados"></button>
        </section>
      </div>
    </main>

    <footer>
      <div class="footer_item">
        <h3>&copy; 2024 - ECO</h3>
      </div>
    </footer>
  </div>
  <script src="js/index.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>