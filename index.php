<html>

<head>

	<title>#FiqueEmCasa</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">

	<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <link rel="icon" type="image/png" href="favicon.png">
  <meta property="og:image" content="http://vamosficaremcasa.com.br/assets/anticovid-br.png">


	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body>

  <div id="covid-app">

    <header>
      <div class="container flex">

        <div class="share"></div>

        <a href="./" class="logo">
          <div class="mask rotate"></div>
          <img src="assets/anticovid-br.png" />
        </a>

        <div class="translate"></div>

      </div>
    </header>
    
    <div class="flags"></div>
    
    <section class="example">

      <div class="container flex">

      <?php 

      if ($_FILES['avatar']) {

        $button_text = 'alterar outra foto';

        $mask = new Imagick("./assets/mask-br.png");
        $avatar = new Imagick($_FILES['avatar']['tmp_name']);

        $width = $avatar->getImageWidth();
        $height = $avatar->getImageHeight();

        $avatar->setCompressionQuality(100);
        $avatar->cropThumbnailImage(640, 640);

        if ($width > $height) {
          $avatar->rotateimage(new ImagickPixel('#00000000'), 90);
        }

        $avatar->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
        $avatar->setImageArtifact('compose:args', "1,0,-0.5,0.5");
        $avatar->compositeImage($mask, Imagick::COMPOSITE_DEFAULT, 0, 0);

        echo "
        <a href='data:image/jpg;base64,".base64_encode($avatar)."' download='avatar.jpg'>
          <img class='result' src='data:image/jpg;base64,".base64_encode($avatar)."' />
          <div>Clique para baixar</div>
        </a>
        ";


        // loga
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
          $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
          $ipaddress = 'UNKNOWN';
        
        $data = date('Y-m-d H:i:s');

        $fp = fopen('./data.txt', 'at');
        fwrite($fp, "data: ${data}, ip: ${ipaddress}\n");
        fclose($fp);
      } else {
        $button_text = 'alterar minha foto';
        ?>

          <img class="mobile" src="assets/example-br-mobile.jpg" alt="Exemplo do resultado" v-on:click="openImageUpload()"/>
          <img class="desktop" src="assets/example-br.jpg" alt="Exemplo do resultado" v-on:click="openImageUpload()"/>
          
          <?php
      }
      
      ?>
      
      </div>
    </section>


    <section class="stay-home p10">

      <div class="container">

        <h1>#fique<span>em</span>casa</h1>

        <p>
          Incentive seus amigos e conhecidos a permanecerem em seus lares, alterando <b>a foto do perfil do seu
            WhatsApp, Instagram, Facebook, Twitter</b>, com o selo desta campanha.
        </p>

      </div>

    </section>


    <div class="space flex">
      <div class="circle rotate"></div>
    </div>



    <section class="respect p30">
      <div class="container">

        <h1>respeito <span>&</span> gratidão</h1>

        <p>
          Expressamos o nosso profundo respeito e gratidão aos <b>corajosos profissionais da saúde</b> e
          cuidadores de todo o planeta <span class="heart">❤️</span> por cuidar de todos nós e também a todos que aderiram a campanha
          <b>#fiqueemcasa</b>.
        </p>

        <p>
          Que Deus abençoe a todos, nos dando fé e paciência para suportar esta preciosa lição que, de certo modo,
          une toda a humanidade.
        </p>

      </div>
    </section>




    <section class="covid-19 p30">
      <div class="container">
        <h2>COVID-19</h2>

        <p>
          Fique tranquilo. É só uma questão de tempo até a situação voltar ao normal. A cura já chegou. Mas para
          isso funcionar é preciso que você e eu façamos a nossa parte, seguindo todas as orientações da OMS e
          controles de saúde local.
        </p>

        <p>
          Precisamos FICAR EM CASA.
        </p>
      </div>
    </section>



    <section class="stay-home p10">
      <div class="container">
        <h2>#fique<span>em</span>casa</h2>
        <div class="waves" alt="ondas do bem"></div>
      </div>
    </section>




    <section class="contact">
      <div class="container">
        <a href="mailto:contato@vamosficaremcasa.com.br" alt="Contato por email">Contato</a>
      </div>
    </section>






    <footer>
      <div class="container">
        <button v-if="!isLoading" class="btn" v-on:click="openImageUpload()"><?php echo $button_text; ?></button>
        <button v-if="isLoading" class="btn disabled">...enviando sua foto</button>
        </div>
      <div class="hr"></div>
    </footer>














    <form id="form" class="form" method="POST" action="" enctype="multipart/form-data">
      <input id="fileInput" type="file" name="avatar" type="file"  v-on:change="fileChanges()" />
    </form>





  </div>


</body>

<script>

var covidApp = new Vue({
  el: '#covid-app',
  data: function () {
    return {
      isLoading: false
    }
  },
  methods: {
    openImageUpload: function() {
      document.getElementById('fileInput').click();
    },
    fileChanges: function() {
      if (!this.isLoading) {
        this.isLoading = true;
        document.getElementById("form").submit();
      }
    }
  },
  mounted: function() {
  }
})

</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56523711-16"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-56523711-16');
</script>


</html>

