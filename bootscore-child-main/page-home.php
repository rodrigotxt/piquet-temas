<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();
?>
<div class="home-intro">
    <div class="row animate__animated animate__fadeInUp animate__delay-1s">
        <div class="col-md-8 rectangle">
            <div class="row">
                <div class="col-md-8 offset-md-3">
                    <div class="text">
                        <h1>Imobiliária de Luxo Líder em Miami, <span class="text-red">agora em Portugal.</span></h1>
                        <p class="sub">A Piquet Realty Portugal atua no mercado imobiliário com foco num atendimento
                            exclusivo e
                            diferenciado.
                            Juntamos a nossa história e tradição dos EUA com a experiência e o network de Portugal.</p>
                    </div>
                    <div id="search-box" class="row align-items-center g-1">
                        <div class="col">
                            <button type="button" class="btn btn-danger">Comprar</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-outline-secondary">Vender</button>
                        </div>
                        <div class="col">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Casas e Apartamentos</option>
                                <option value="1">Terrenos</option>
                                <option value="2">Salas Comerciais</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Cidade, Município, Freguesia..."
                                aria-label="Recipient's username" aria-describedby="button-addon2">
                        </div>
                        <div class="col">
                            <button class="btn btn-danger" type="button" id="button-addon2">Procurar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="photos col-md-4">
            <img class="" src="<?= base_dir() ?>/img/home/home-foto01.png" alt="">
        </div>
    </div>
</div>

<div id="content" class="site-content container py-5 mt-5">
    <div id="primary" class="content-area">
        <!-- Hook to add something nice -->
        <?php bs_after_primary(); ?>
        <section class="listagem">
            <div class="section-title">IMÓVEIS</div>
            <div class="row py-5">
                <h2>Descubra os imóveis disponíveis<br>
                    hoje na zona de Lisboa</h2>
            </div>
            <div class="row list">
                <?php $imoveis = getMoveisHome();
                for ($i = 0; $i < count($imoveis); $i++) {  ?>
                <div class="col-md-4 mt-5">
                    <?= showBoxImovel($imoveis[$i]) ?>
                </div>
                <?php }; ?>

                <div class="text-center my-5">
                    <a href="#" class="btn btn-danger">Lista de imóveis</a>
                </div>
            </div>
        </section>

        <section id="servicos">
            <div class="row">
                <div class="rectangle col-md-6"></div>
            </div>
            <div class="container">
                <div class="section-title">SERVIÇOS</div>
                <div class="row py-5">
                    <h2>Venda o seu Imóvel Conosco<br>
                        e conheça os benefícios</h2>
                </div>
                <div class="row list">
                    <div class="col-md-4">
                        <div class="box">
                            <img src="<?= base_url() ?>/img/home/home-icon-serv01.png" alt="">
                            <p>Venda seu Imóvel</p>
                            <p>Estamos prontos para vender sua propriedade a qualquer momento, em qual zona</p>
                            <a href="#">SAIBA MAIS</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <img src="<?= base_url() ?>/img/home/home-icon-serv02.png" alt="">
                            <p>Parceiros Comerciais</p>
                            <p>Estamos prontos para vender sua propriedade a qualquer momento, em qualquer zona</p>
                            <a href="#">SAIBA MAIS</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <img src="<?= base_url() ?>/img/home/home-icon-serv01.png" alt="">
                            <p>Marketing Interno</p>
                            <p>Estamos prontos para vender sua propriedade a qualquer momento, em qualquer zona</p>
                            <a href="#">SAIBA MAIS</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="destaque">
            <div class="container">
                <!-- <div class="section-title">DESTAQUE</div> -->
                <?php $post = getImovelDestaque();
                $dados = get_fields($post->ID);
                ?>
                <div class="row py-5">
                    <h2>Destaque do mês: <?= $post->post_title  ?><br>
                        <?= $dados['endereco']['cidade'] ?>, <?= $dados['endereco']['bairro'] ?></h2>
                </div>
                <div class="row">
                    <div class="col-md-4 align-self-center">
                        <div class="box-text">
                            <h3>Características do Imóvel</h3>
                            <?= $dados['caracteristicas_resumo'] ?>
                            <p>
                                <a href="<?= get_the_permalink() ?>" class="btn btn-danger mr-5">Saiba mais</a>
                                <?php $video = $dados['video_link']; ?>
                                <a href="#" onclick="openModal('video', '<?= $video ?>')"><img
                                        src="<?= base_url() ?>/img/home/home-icon-play.png" alt=""></a>
                            </p>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <img src="<?= base_url() ?>/img/home/home-foto03.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section id="contacto">
            <div class="row">
                <div class="rectangle col-md-6"></div>
            </div>
            <div class="section-title">CONTACTO</div>
            <div class="row py-5">
                <h2>Fale com a nossa equipa de vendas<br>
                    ou receba mais informações</h2>
            </div>
            <div class="row">
                <form action="" method="post" class="col-md-8 offset-md-2 box-contacto">
                    <h3>Preencha o formulário:</h3>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <!-- <label for="nomeInput" class="form-label">Nome</label> -->
                            <input type="text" class="form-control" id="nomeInput" placeholder="Nome">
                        </div>
                        <div class="mb-3 col-md-6">
                            <!-- <label for="telefoneInput" class="form-label">Telefone</label> -->
                            <input type="text" class="form-control" id="telefoneInput" placeholder="Telefone">
                        </div>
                        <div class="mb-3 col-md-6">
                            <!-- <label for="emailInput" class="form-label">Email</label> -->
                            <input type="email" class="form-control" id="emailInput" placeholder="Email">
                        </div>
                        <div class="mb-3 col-md-6">
                            <!-- <label for="cidadeInput" class="form-label">Cidade</label> -->
                            <input type="email" class="form-control" id="cidadeInput" placeholder="Cidade">
                        </div>
                        <div class="mb-3">
                            <!-- <label for="msgTextarea1" class="form-label">Mensagem</label> -->
                            <textarea class="form-control" id="msgTextarea1" rows="3"
                                placeholder="Sua mensagem"></textarea>
                        </div>
                        <div class="mb-3 my-3">
                            <button class="btn btn-danger">Enviar <i class="ml-3 fas fa-angle-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section id="noticias">
            <div class="section-title">NOTÍCIAS</div>
            <div class="row py-5">
                <h2>Veja as mais recentes notícias<br>
                    do mercado imobiliário</h2>
            </div>
            <div class="row posts">
                <?php for ($i = 0; $i < 4; $i++) { ?>
                <div class="col-md-3">
                    <div class="box">
                        <figure>
                            <a href="#"><img src="<?= base_url() ?>/img/home/box-noticia.png" alt=""></a>
                        </figure>
                        <!-- <p>Veja as mais recentes notícias do mercado imobiliário</p> -->
                    </div>
                </div>
                <?php }; ?>
            </div>
        </section>

    </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();