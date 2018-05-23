<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Gerador Fiscal</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#services">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#portfolio">Galeria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Yii::$app->urlManagerBackend->createUrl('site/index') ?>">Entrar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="masthead text-center text-white d-flex">
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="text-uppercase">
                    <strong>Sua transportadora na direção certa!</strong>
                </h1>
                <hr>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="text-faded mb-5">Emita CT-e e MDF-e de forma simples e segura. Maior controle sobre sua frota e funcionários. Não fique no vermelho com nosso módulo financeiro!</p>
                <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Descubra mais</a>
            </div>
        </div>
    </div>
</header>

<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading text-white">Nós temos o que você procura!</h2>
                <hr class="light my-4">
                <p class="text-faded mb-4">Emita documentos fiscais (Conhecimento de Transporte e Manifesto) com segurança e agilidade. Tenha controle de sua empresa e amplie suas possibilidades.s</p>
                <a class="btn btn-light btn-xl js-scroll-trigger" href="#services">Nossos serviços!</a>
            </div>
        </div>
    </div>
</section>

<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">A sua disposição, sempre!</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-diamond text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Maior segurança</h3>
                    <p class="text-muted mb-0">Servidores monitorados e informações do sistema a prova de hackers.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-paper-plane text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Rapidez na emissão</h3>
                    <p class="text-muted mb-0">Emita documentos com maior agilidade e transmita de forma segura.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-newspaper-o text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Sempre atualizado</h3>
                    <p class="text-muted mb-0">Melhorias contínuas na plataforma de emissão.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-usd text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Baixo custo</h3>
                    <p class="text-muted mb-0">Preços fixos. Sem surpresas!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="p-0" id="portfolio">
    <div class="container-fluid p-0">
        <div class="row no-gutters popup-gallery">
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/sistema_inicial.png">
                    <img class="img-fluid" src="img/portfolio/thumbnails/sistema_inicial.png" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Gerador Fiscal
                            </div>
                            <div class="project-name">
                                Tela Inicial
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/sistema_cotacao.png">
                    <img class="img-fluid" src="img/portfolio/thumbnails/sistema_cotacao.png" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Gerador Fiscal
                            </div>
                            <div class="project-name">
                                Cotação
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/sistema_funcionario.png">
                    <img class="img-fluid" src="img/portfolio/thumbnails/sistema_funcionario.png" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Gerador Fiscal
                            </div>
                            <div class="project-name">
                                Funcionários
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/sistema_cte.png">
                    <img class="img-fluid" src="img/portfolio/thumbnails/sistema_cte.png" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Gerador Fiscal
                            </div>
                            <div class="project-name">
                                CT-e
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/sistema_mdfe.png">
                    <img class="img-fluid" src="img/portfolio/thumbnails/sistema_mdfe.png" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Gerador Fiscal
                            </div>
                            <div class="project-name">
                                MDF-e
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="img/portfolio/fullsize/sistema_relatorio.png">
                    <img class="img-fluid" src="img/portfolio/thumbnails/sistema_relatorio.png" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Gerador Fiscal
                            </div>
                            <div class="project-name">
                                Relatórios
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- <section class="bg-dark text-white">
  <div class="container text-center">
    <h2 class="mb-4">Free Download at Start Bootstrap!</h2>
    <a class="btn btn-light btn-xl sr-button" href="http://startbootstrap.com/template-overviews/creative/">Download Now!</a>
  </div>
</section> -->

<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading">Entre em contato</h2>
                <hr class="my-4">
                <p class="mb-5">Pronto para conhecer a melhor ferramenta para transportadoras da atualidade? Solicite um teste: é grátis!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 ml-auto text-center">
                <i class="fa fa-whatsapp fa-3x mb-3 sr-contact"></i>
                <p>(31)99844-1339</p>
            </div>
            <div class="col-lg-4 mr-auto text-center">
                <i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
                <p>
                    <a href="mailto:diasnlucas@gmail.com">diasnlucas@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</section>