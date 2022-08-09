<?php
/*
	 * Template Post Type: post
	 */

get_header();
$dados = get_fields();
$images = $dados['imagens'];
?>

<script>
    // POST
    var post = JSON.parse(atob('<?= base64_encode(json_encode($post)) ?>'));
</script>

<div id="slide-imovel">
    <?= showSlides($images, 'banner-size') ?>
</div>

<div id="content" class="site-content container pb-5">
    <div id="primary" class="content-area">
        <!-- Hook to add something nice -->
        <?php bs_after_primary(); ?>

        <?php the_breadcrumb(); ?>

        <div class="anchor-links">
            <a href="#fotos" data-params='<?= json_encode($images) ?>' onclick="openModal('gallery', JSON.parse(this.getAttribute('data-params')), post)" class="btn"><i class="far fa-file-image"></i> Fotos</a>
            <a href="#video" onclick="openModal('video', '<?= $dados['video_link'] ?>')" class="btn"><i class="fas fa-play"></i> Vídeo</a>
            <a href="#planta" data-params='<?= json_encode($dados['plantas']) ?>' onclick="openModal('gallery', JSON.parse(this.getAttribute('data-params')), post)" class="btn"><i class="fas fa-th"></i> Planta</a>
            <a href="#mapa" class="btn"><i class="fas fa-map-marker-alt"></i> Mapa</a>
            <a href="#tour-virtual" class="btn"><i class="fas fa-arrows-alt"></i> Tour Virtual</a>
        </div>

        <?php the_post(); ?>
        <div class="row head mt-5">
            <div class="col-md-9">
                <?php the_title('<h1>', '</h1>'); ?>
                <?php $endereco = $dados['endereco']; ?>
                <p class="address">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= $endereco['tipo'] . ' ' . $endereco['logradouro'] . ', ' . $endereco['numero'] . ', ' . $endereco['cidade'] ?>
                </p>
            </div>
            <div class="col-md-3 text-end">
                <h2 class="price"><?= valorMonetario($dados['valor_do_imovel']) ?></h2>
                <div class="anchor-links">
                    <a href="#compartilhar" class="btn"><i class="fas fa-share-alt"></i> Compartilhar</a>
                    <a href="#print" class="btn"><i class="fas fa-print"></i> Print</a>
                </div>
            </div>
        </div>

        <section id="main">
            <div class="row">
                <div class="col-md-8 col-xxl-9">
                    <div class="box-resumo box-imovel p-3">
                        <?php $c = $dados['caracteristicas']; ?>
                        <p class="title">Apartamento <?= $c['quartos'] ?>T em <?= $dados['endereco']['bairro'] ?></p>
                        <div class="row">
                            <div class="date col-md-3">
                                Última atualização<br>
                                <?= get_the_date() ?>
                            </div>
                            <div class="icons col-md-9">
                                <ul>
                                    <li class="bed">T2</li>
                                    <li class="bath">2 banheiros</li>
                                    <li class="square">95 m<sup>2</sup></li>
                                    <li class="car">1 vaga</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <main id="main" class="site-main box-shadow my-5">
                        <?php the_content() ?>
                    </main> <!-- #main -->
                    <div class="box-shadow box-detalhes">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Características de Áreas</strong></p>
                                <?= $dados['caracteristicas_areas'] ?>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Características Específicas</strong></p>
                                <?= $dados['caracteristicas_especificas'] ?>
                                Desempenho Energético: <?= $dados['desempenho_energetico'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <h2>Características</h2>
                        <div id="carousel" class="caracteristicas mt-2">
                            <?= showSlides($dados['imagens_caracteristicas']) ?>
                        </div>
                    </div>

                    <div class="row tour mt-3" id="tour-virtual">
                        <div class="box-shadow">
                            <h4>Tour Virtual</h4>
                            <iframe width="100%" height="400" src="https://www.tourbrasil360.com/imoveis/brz/extrema/" frameborder="0"></iframe>
                        </div>
                    </div>
                    <div class="row tour mt-3" id="video">
                        <div class="box-shadow">
                            <h4>Vídeo</h4>
                            <?php $video = $dados['video_link']; ?>
                            <?= wp_oembed_get($video, array('width' => 1200)) ?>
                        </div>
                    </div>
                    <div class="row mapa mt-3 mb-5" id="mapa">
                        <div class="box-shadow">
                            <h4>Mapa</h4>
                            <?php $location = get_field('mapa');
                            if ($location) : ?>
                                <div class="acf-map" data-zoom="16">
                                    <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row relacionados mt-5">
                        <h4>Imóveis Semelhantes</h4>
                        <?php $imoveis = getImoveis(); ?>
                        <?php
                        for ($i = 0; $i < count($imoveis); $i++) {  ?>
                            <div class="col-md-4 mt-5">
                                <?= showBoxImovel($imoveis[$i]) ?>
                            </div>
                        <?php }; ?>
                    </div>

                </div><!-- col -->
                <div class="col-md-4 col-xxl-3">
                    <!-- <?php get_sidebar(); ?> -->
                    <div class="box-shadow">
                        <div class="container p-2">
                            <p class="my-3">Agende sua Visita</p>
                            <input type="text" class="form-control mt-2" name="nome" placeholder="Nome">
                            <input type="email" class="form-control mt-2" name="email" placeholder="Email">
                            <input type="text" class="form-control mt-2" name="telefone" placeholder="Telefone">
                            <textarea class="form-control mt-2" name="mensagem" id="" cols="30" rows="5" placeholder="Mensagem"></textarea>
                            <button class="btn btn-danger w-100 my-3">Contactar</button>
                            <p class="mt-3 mb-0"><strong>Fale com a Piquet</strong></p>
                            <div class="row gx-3 p-1 justify-content-around">
                                <button class="col-12 my-3 btn border border-danger"><i class="fas fa-phone"></i>
                                    <span class="text-gray">+351</span> 901 002 345</button>
                                <button class="col-12 btn border border-danger"><i class="fab fa-whatsapp"></i>
                                    Whatsapp</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div><!-- #primary -->
</div><!-- #content -->

<?php get_footer(); ?>