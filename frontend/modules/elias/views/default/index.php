<?php
$dir = '/Transportes/frontend/web/vendor/BizPage/img/';
?>

<!--==========================
    Header
  ============================-->
<header id="header">
    <div class="container-fluid">

        <div id="logo" class="pull-left">
            <!-- <h1><a href="#intro" class="scrollto">Elias Transportes</a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="#intro" class="scrollto"><img src="<?=$dir;?>logo2.png" alt="" title="" /></a>
        </div>

        <nav id="nav-menu-container">
            <ul class="nav-menu">
                <li class="menu-active"><a href="#intro">Início</a></li>
                <li><a href="#about">Sobre</a></li>
                <li><a href="#services">Serviços</a></li>
                <li><a href="#clients">Clientes</a></li>
                <!-- <li class="menu-has-children"><a href="">Drop Down</a>
                  <ul>
                    <li><a href="#">Drop Down 1</a></li>
                    <li><a href="#">Drop Down 3</a></li>
                    <li><a href="#">Drop Down 4</a></li>
                    <li><a href="#">Drop Down 5</a></li>
                  </ul>
                </li> -->
                <li><a href="#contact">Contato</a></li>
                <li><a href="<?= Yii::$app->urlManagerBackend->createUrl('site/index') ?>"><i class="ion-log-in"></i></a></li>
            </ul>
        </nav><!-- #nav-menu-container -->
    </div>
</header><!-- #header -->

<!--==========================
  Intro Section
============================-->
<section id="intro">
    <div class="intro-container">
        <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

            <ol class="carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                <div class="carousel-item active">
                    <div class="carousel-background"><img src="<?=$dir;?>intro-carousel/1.jpg" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>Nós somos profissionais</h2>
                            <p>Equipe de trabalho qualificada. Conte com nossa empresa e tenha a certeza de seus produtos chegando aos destinatários. </p>
                            <a href="#featured-services" class="btn-get-started scrollto">Saiba mais</a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="carousel-background"><img src="<?=$dir;?>intro-carousel/2.jpg" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>Agilidade nas entregas</h2>
                            <p>Excelência em Cargas Urgentes.</p>
                            <a href="#featured-services" class="btn-get-started scrollto">Saiba mais</a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="carousel-background"><img src="<?=$dir;?>intro-carousel/3.png" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>Melhor custo benefício</h2>
                            <p>Solicite sua cotação e confirme que nossos fretes são os melhores do mercado.</p>
                            <a href="#contact" class="btn-get-started scrollto">Cotação</a>
                        </div>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>

            <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
            </a>

        </div>
    </div>
</section><!-- #intro -->

<main id="main">

    <!--==========================
      Featured Services Section
    ============================-->
    <section id="featured-services">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 box">
                    <i class="ion-ios-bookmarks-outline"></i>
                    <h4 class="title"><a href="">Programe seu frete</a></h4>
                    <p class="description">Agende com nossa equipe quando e onde coletar e entregar seus produtos.</p>
                </div>

                <div class="col-lg-4 box box-bg">
                    <i class="ion-ios-stopwatch-outline"></i>
                    <h4 class="title"><a href="">Pontualidade</a></h4>
                    <p class="description">Cumprimos rigorosamente os prazos combinados com os clientes.</p>
                </div>

                <div class="col-lg-4 box">
                    <i class="ion-ios-heart-outline"></i>
                    <h4 class="title"><a href="">Parceria de confiança</a></h4>
                    <p class="description">Mais que uma prestação de serviços, uma relação de familiaridade com nossos clientes.</p>
                </div>

            </div>
        </div>
    </section><!-- #featured-services -->

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
        <div class="container">

            <header class="section-header">
                <h3>Sobre Nós</h3>
                <p>Somos uma empresa de transportes com foco em entragas rápidas e seguras. Contamos com um equipe de profissionais qualificada para atedê-los com excelência. Nossa frota suscita uma prestação de serviço de qualidade e nossos preços nos definem como a melhor escolha para sua empresa.</p>
            </header>

            <div class="row about-cols">

                <div class="col-md-4 wow fadeInUp">
                    <div class="about-col">
                        <div class="img">
                            <img src="<?=$dir;?>missao.jpg" alt="" class="img-fluid">
                            <div class="icon"><i class="ion-ios-cog-outline"></i></div>
                        </div>
                        <h2 class="title"><a href="#">Nossa Missão</a></h2>
                        <p>
                            Prestar serviços de transportes em todas as modalidades, com respeito e cuidado aos clientes e produtos.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="about-col">
                        <div class="img">
                            <img src="<?=$dir;?>visao.jpg" alt="" class="img-fluid">
                            <div class="icon"><i class="ion-ios-eye-outline"></i></div>
                        </div>
                        <h2 class="title"><a href="#">Nossa Visão</a></h2>
                        <p>
                            Sermos reconhecidos como referência no transporte de cargas, contribuindo para o crescimento dos nossos clientes.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="about-col">
                        <div class="img">
                            <img src="<?=$dir;?>valores.png" alt="" class="img-fluid">
                            <div class="icon"><i class="ion-ios-list-outline"></i></div>
                        </div>
                        <h2 class="title"><a href="#">Nossos Valores</a></h2>
                        <p>
                            Honestidade, Pontualidade, Respeito, Compromisso, Dedicação e Inovação.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services">
        <div class="container">

            <header class="section-header wow fadeInUp">
                <h3>Serviços</h3>
                <p>Confira o que fazemos de melhor.</p>
            </header>

            <div class="row">

                <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                    <div class="icon"><i class="ion-android-car"></i></div>
                    <h4 class="title"><a href="">Fretes Urgentes</a></h4>
                    <p class="description">Coletas e entregas urgentes.</p>
                </div>
                <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                    <div class="icon"><i class="ion-ios-locked"></i></div>
                    <h4 class="title"><a href="">Carga Segura</a></h4>
                    <p class="description">Garantimos a segurança dos seus produtos.</p>
                </div>
                <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                    <div class="icon"><i class="ion-calendar"></i></div>
                    <h4 class="title"><a href="">Transportes agendados</a></h4>
                    <p class="description">Agende seu frete e tenha certeza da entrega pontual.</p>
                </div>
            </div>

        </div>
    </section><!-- #services -->

    <!--==========================
      Call To Action Section
    ============================-->
    <section id="call-to-action" class="wow fadeIn">
        <div class="container text-center">
            <h3>Solicite Uma Cotação</h3>
            <p> Entre em contato e faça um orçamento sem compromisso. Você vai se surpreender com nossos preços.</p>
            <a class="cta-btn scrollto" href="#contact">Solicitar Cotação</a>
        </div>
    </section><!-- #call-to-action -->

    <!--==========================
      Facts Section
    ============================-->
    <section id="facts"  class="wow fadeIn">
        <div class="container">

            <header class="section-header">
                <h3>Nossos números</h3>
                <p>Ainda mais motivos para contratar nossos serviços.</p>
            </header>

            <div class="row counters">

                <div class="col-lg-3 col-6 text-center">
                    <span data-toggle="counter-up">4.500</span>
                    <p>Clientes já atendidos</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-toggle="counter-up">15.000</span>
                    <p>Entregas</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-toggle="counter-up">27</span>
                    <p>Colaboradores</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-toggle="counter-up">10</span>
                    <p>Anos de experiência</p>
                </div>

            </div>

            <!-- <div class="facts-img">
              <img src="img/facts-img.png" alt="" class="img-fluid">
            </div> -->

        </div>
    </section><!-- #facts -->

    <!--==========================
      Clients Section
    ============================-->
    <section id="clients" class="wow fadeInUp">
        <div class="container">

            <header class="section-header">
                <h3>Nossos clientes</h3>
            </header>

            <div class="owl-carousel clients-carousel">
                <img src="<?=$dir;?>clients/cliente1.png" alt="">
                <img src="<?=$dir;?>clients/cliente2.png" alt="">
                <img src="<?=$dir;?>clients/cliente3.png" alt="">
            </div>

        </div>
    </section><!-- #clients -->

    <!--==========================
      Clients Section
    ============================-->
    <section id="testimonials" class="section-bg wow fadeInUp">
        <div class="container">

            <header class="section-header">
                <h3>Depoimentos</h3>
            </header>

            <div class="owl-carousel testimonials-carousel">

                <div class="testimonial-item">
                    <img src="<?=$dir;?>testimonial-1.jpg" class="testimonial-img" alt="">
                    <h3>Nome UM</h3>
                    <h4>Função</h4>
                    <p>
                        <img src="<?=$dir;?>quote-sign-left.png" class="quote-sign-left" alt="">
                        É muito bom poder agendar meus fretes e não precisar me preocupar.
                        <img src="<?=$dir;?>quote-sign-right.png" class="quote-sign-right" alt="">
                    </p>
                </div>

                <div class="testimonial-item">
                    <img src="<?=$dir;?>testimonial-2.jpg" class="testimonial-img" alt="">
                    <h3>Nome DOIS</h3>
                    <h4>Função</h4>
                    <p>
                        <img src="<?=$dir;?>quote-sign-left.png" class="quote-sign-left" alt="">
                        O valor dos fretes é o grande diferencial.
                        <img src="<?=$dir;?>quote-sign-right.png" class="quote-sign-right" alt="">
                    </p>
                </div>

            </div>

        </div>
    </section><!-- #testimonials -->

    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="section-bg wow fadeInUp">
        <div class="container">

            <div class="section-header">
                <h3>Contato</h3>
                <p>Entre em contato conosco para tirar suas dúvidas, solicitar cotações ou contratar nossos serviços.</p>
            </div>

            <div class="row contact-info">

                <div class="col-md-4">
                    <div class="contact-address">
                        <i class="ion-ios-location-outline"></i>
                        <h3>Endereço</h3>
                        <address>Ribeirão das Neves / Minas Gerais</address>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-phone">
                        <i class="ion-ios-telephone-outline"></i>
                        <h3>Telefones</h3>
                        <p><a href="tel:+5531996479804">(31)99647-9804</a></p>
                        <h6><i class="ion-social-whatsapp-outline" style="font-size: 18px"></i>
                            <a href="tel:+5531991097837">(31)99109-7837</a></h6>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-email">
                        <i class="ion-ios-email-outline"></i>
                        <h3>E-mail</h3>
                        <p><a href="mailto:eliastransportesrapidos@gmail.com">eliastransportesrapidos@gmail.com</a></p>
                    </div>
                </div>

            </div>

            <div class="form">
                <div id="sendmessage">Sua mensagem foi enviada. Obrigado!</div>
                <div id="errormessage"></div>
                <form action="" method="post" role="form" class="contactForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nome" data-rule="minlen:4" data-msg="Informe no mínimo 4 caracteres" />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" data-rule="email" data-msg="Endereço de e-mail inválido" />
                            <div class="validation"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="subject" id="subject" placeholder="Assunto" data-rule="minlen:4" data-msg="Informe no mínimo 4 caracteres" >
                            <option value="Cotação">Cotação</option>
                            <option value="Financeiro">Financeiro</option>
                        </select>
<!--                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Assunto" data-rule="minlen:4" data-msg="Informe no mínimo 4 caracteres" />-->
                        <div class="validation"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" id="message" rows="5" data-rule="required" data-msg="Escreva alguma mensagem" placeholder="Mensagem">
Cidade Coleta:
Cidade Entrega:
Volumes:
Peso:
Dimensões:
Valor da NF:
                        </textarea>
                        <div class="validation"></div>
                    </div>
                    <div class="text-center"><button type="submit">Enviar Mensagem</button></div>
                </form>
            </div>

        </div>
    </section><!-- #contact -->

</main>

<!--==========================
  Footer
============================-->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-info">
                    <h3>Elias Transportes Rápidos</h3>
                    <p>Uma empresa de transportes com foco em entragas rápidas e seguras.</p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Links úteis</h4>
                    <ul>
                        <li><i class="ion-ios-arrow-right"></i> <a href="#intro" class="scrollto">Início</a></li>
                        <li><i class="ion-ios-arrow-right"></i> <a href="#about" class="scrollto">Sobre</a></li>
                        <li><i class="ion-ios-arrow-right"></i> <a href="#services" class="scrollto">Serviços</a></li>
                        <li><i class="ion-ios-arrow-right"></i> <a href="#clients" class="scrollto">Clientes</a></li>
                        <li><i class="ion-ios-arrow-right"></i> <a href="#contact" class="scrollto">Contato</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>Contatos</h4>
                    <p>
                        Ribeirão das Neves<br>
                        Minas Gerais / Brasil <br>
                        <strong>Tel:</strong> (31)99647-9804<br>
                        <i class="ion-social-whatsapp-outline" style="font-size: 18px"></i>
                        (31)99109-7837<br>
                        eliastransportesrapidos@gmail.com<br>
                    </p>

                    <div class="social-links">
                        <!-- <a href="#" class="twitter"><i class="fa fa-twitter"></i></a> -->
                        <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                        <!-- <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a> -->
                        <!-- <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a> -->
                    </div>

                </div>

                <div class="col-lg-3 col-md-6 footer-newsletter">
                    <h4>Novidades</h4>
                    <p>Cadastre seu e-mail e seja o primeiro a receber novidades e promoções.</p>
                    <form action="" method="post">
                        <input type="email" name="email"><input type="submit"  value="Cadastrar">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Elias Transportes Rápidos</strong>. Todos os direitos reservados
        </div>
        <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=BizPage
            -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer><!-- #footer -->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<div id="preloader"></div>