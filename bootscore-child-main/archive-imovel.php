<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */
function isSelected($var1, $var2) {
    if ($var1 == $var2) return 'selected';
}
$opt = get_fields('options');
get_header();
?>

<div id="content" class="site-content container py-5 mt-5">
    <div id="primary" class="content-area">

        <!-- Hook to add something nice -->
        <?php bs_after_primary(); ?>

        <div class="row">
            <div class="col">

                <main id="main" class="site-main mt-3">

                    <!-- Title & Description -->
                    <header class="page-header row mb-4 animate__animated animate__fadeInDown">
                        <div class="col-md-8 my-3">
                            <h1>Lista de Propriedades</h1>
                        </div>
                        <div class="col-md-4 align-self-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-secondary active">Lista</a>
                                    <a href="#" class="btn btn-outline-secondary">Mapa</a>
                                </div>
                                <div class="col-md-6">
                                    <select name="order" id="order-imovel" class="form-select form-select-sm">
                                        <option>Ordenar por</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </header>

                    <div class="row">
                        <div class="col-md-8 animate__animated animate__fadeInLeft" id="lista-imoveis">
                            <!-- Grid Layout -->
                            <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                            <?php $dados = get_fields(get_the_ID()); ?>
                            <div class="card horizontal mb-4 box-shadow">
                                <div class="row">
                                    <!-- Featured Image-->
                                    <?php if (has_post_thumbnail())
                                                echo '<div class="card-img-left-md col-lg-5">' . get_the_post_thumbnail(null, 'medium') . '</div>';
                                            ?>
                                    <div class="col">
                                        <div class="card-body">

                                            <?php bootscore_category_badge(); ?>

                                            <!-- Title -->
                                            <h2 class="blog-post-title">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>
                                            <!-- Excerpt & Read more -->
                                            <div class="card-text mt-auto">
                                                <?= $dados['caracteristicas_resumo'] ?>
                                                <div class="icons">
                                                    <ul>
                                                        <li class="bed">T<?= $dados['caracteristicas']['quartos'] ?>
                                                        </li>
                                                        <li class="bath"> <?= $dados['caracteristicas']['banheiros'] ?>
                                                        </li>
                                                        <li class="square"><?= $dados['caracteristicas']['m2'] ?>
                                                            m<sup>2</sup></li>
                                                        <li class="car">
                                                            <?= $est = $dados['caracteristicas']['vagas_estacionamento']; ?>
                                                            vaga<?= $est > 1 ? 's' : '' ?></li>
                                                    </ul>
                                                </div>
                                                <div class="contact">
                                                    <button class="btn">
                                                        <i class="fas fa-phone-alt"></i>
                                                        <span class="text-gray">+351</span> 901 002 345</button>
                                                    <button class="btn"><i class="fab fa-whatsapp"></i>
                                                        Whatsapp</button>
                                                    <div class="share">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm"><i
                                                                class="fas fa-share-alt"></i></button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary"><i
                                                                class="far fa-heart"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tags -->
                                            <?php bootscore_tags(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 animate__animated animate__fadeInRight" id="filtrosBarra">
                            <form action="" method="get">
                                <div class="box-shadow p-3">
                                    <div class="mb-3 animate__animated animate__fadeIn">
                                        <label class="" for="tipoImovel" class="form-label">Tipo de Imóvel</label>
                                        <select name="tipoImovel" id="tipoImovel" class="form-select form-select-sm"
                                            v-model="form.tipoImovel">
                                            <option <?= $_GET['tipoImovel'] == 'Apartamento' ? 'selected' : '' ?>>
                                                Apartamento</option>
                                            <option <?= $_GET['tipoImovel'] == 'Casa' ? 'selected' : '' ?>>Casa</option>
                                            <option <?= $_GET['tipoImovel'] == 'Terreno' ? 'selected' : '' ?>>Terreno
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3 animate__animated animate__fadeIn">
                                        <label for="preco" class="form-label">Preço</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="precoMin" id="precoMin"
                                                    class="form-select form-select-sm">
                                                    <option value="0">Min</option>
                                                    <?php foreach (explode(PHP_EOL, $opt['faixa_preco_venda']) as $key => $value) { ?>
                                                    <option value="<?= trim($value) ?>"
                                                        <?= trim($value) == $_GET['precoMin'] ? 'selected' : '' ?>>
                                                        <?= formatMoney($value) ?>
                                                    </option>
                                                    <?php } ?>
                                                    <option value="null">Sem limite</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="precoMax" id="precoMax"
                                                    class="form-select form-select-sm col-md-6">
                                                    <option value="0">Max</option>
                                                    <?php foreach (explode(PHP_EOL, $opt['faixa_preco_venda']) as $key => $value) { ?>
                                                    <option value="<?= trim($value) ?>"
                                                        <?= trim($value) == $_GET['precoMax'] ? 'selected' : '' ?>>
                                                        <?= formatMoney($value) ?>
                                                    </option>
                                                    <?php } ?>
                                                    <option value="null">Sem limite</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 animate__animated animate__fadeIn">
                                        <label for="tamanhoMin" class="form-label">Tamanho</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="tamanhoMin" id="tamanhoMin"
                                                    class="form-select form-select-sm">
                                                    <option value="0">Min</option>
                                                    <?php foreach (explode(PHP_EOL, $opt['tamanhos_m2']) as $key => $value) { ?>
                                                    <option value="<?= trim($value) ?>"
                                                        <?= isSelected(trim($value), $_GET['tamanhoMin']) ?>>
                                                        <?= $value ?>m²</option>
                                                    <?php } ?>
                                                    <option value="1000">Sem limite</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="tamanhoMax" id="tamanhoMax"
                                                    class="form-select form-select-sm col-md-6">
                                                    <option value="0">Max</option>
                                                    <?php foreach (explode(PHP_EOL, $opt['tamanhos_m2']) as $key => $value) { ?>
                                                    <option value="<?= trim($value) ?>"
                                                        <?= isSelected(trim($value), $_GET['tamanhoMax']) ?>>
                                                        <?= $value ?>m²</option>
                                                    <?php } ?>
                                                    <option value="1000">Sem limite</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 animate__animated animate__fadeIn"
                                        v-if="form.tipoImovel == 'Apartamento'">
                                        <label for="tipoApto" class="form-label">Tipo de Apartamento</label>
                                        <?php foreach ($opt['tipos_apartamentos'] as $k => $value) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="tipoAptoCheck[]" type="checkbox"
                                                value="<?= $value['nome'] ?>" id="tipoAptoCheck<?= $k ?>">
                                            <label class="form-check-label" for="tipoAptoCheck<?= $k ?>">
                                                <?= $value['nome'] ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>
                                    <div class="mb-3 animate__animated animate__fadeIn"
                                        v-if="form.tipoImovel == 'Casa'">
                                        <label for="tipoApto" class="form-label">Tipo de casa e moradia</label>
                                        <?php foreach ($opt['tipos_casas'] as $k => $value) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="tipoCasaCheck[]" type="checkbox"
                                                value="<?= $value['nome'] ?>" id="tipoCasaCheck<?= $k ?>">
                                            <label class="form-check-label" for="tipoCasaCheck<?= $k ?>">
                                                <?= $value['nome'] ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>
                                    <div class="mb-3 animate__animated animate__fadeIn"
                                        v-if="form.tipoImovel == 'Apartamento' || form.tipoImovel == 'Casa'">
                                        <label for="quartos" class="form-label">Quartos</label>
                                        <?php for ($i = 0; $i <= $opt['max_quartos']; $i++) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="quartos[]" type="checkbox" value=""
                                                id="quartos<?= $i ?>">
                                            <label class="form-check-label" for="quartos<?= $i ?>">
                                                T<?= $i ?><?= $i == $opt['max_quartos'] ? ' ou +' : '' ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>

                                    <div class="mb-3 animate__animated animate__fadeIn"
                                        v-if="form.tipoImovel == 'Apartamento' || form.tipoImovel == 'Casa'">
                                        <label for="quartos" class="form-label">Casas de banho</label>
                                        <?php for ($i = 1; $i <= $opt['max_casa_banhos']; $i++) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="casasBanho[]" type="checkbox" value=""
                                                id="casasBanho<?= $i ?>">
                                            <label class="form-check-label" for="casasBanho<?= $i ?>">
                                                <?= $i ?><?= $i == $opt['max_casa_banhos'] ? ' casas de banho ou +' : '' ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="estadoImovel" class="form-label">Estado</label>
                                        <?php foreach ($opt['estado_imovel'] as $i => $value) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="estadoImovel[]" type="checkbox"
                                                value="" id="estadoImovel<?= $i ?>">
                                            <label class="form-check-label" for="estadoImovel<?= $i ?>">
                                                <?= $value['nome'] ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>
                                    <div class="mb-3" v-if="form.tipoImovel == ('Apartamento')">
                                        <label for="andarImovel" class="form-label">Andar</label>
                                        <?php foreach ($opt['andar'] as $i => $value) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="andarImovel[]" type="checkbox"
                                                value="" id="andarImovel<?= $i ?>">
                                            <label class="form-check-label" for="andarImovel<?= $i ?>">
                                                <?= $value['nome'] ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>
                                    <div class="mb-3 animate__animated animate__fadeIn"
                                        v-if="form.tipoImovel == 'Apartamento' || form.tipoImovel == 'Casa'">
                                        <input type="hidden" name="maisFiltros" value="">
                                        <label for="maisFiltro" class="form-label">Mais Filtros</label>
                                        <?php foreach (explode(PHP_EOL, $opt['mais_filtros']) as $i => $value) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="maisFiltro[]" type="checkbox"
                                                value="<?= trim($value) ?>" id="maisFiltro<?= $i ?>">
                                            <label class="form-check-label" for="maisFiltro<?= $i ?>">
                                                <?= trim($value) ?>
                                            </label>
                                        </div>
                                        <?php }; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-10 offset-1 p-2">
                                            <button class="btn btn-lg btn-danger w-100">PESQUISAR</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div>
                        <?php bootscore_pagination(); ?>
                    </div>

                </main><!-- #main -->

            </div><!-- col -->

            <?php get_sidebar(); ?>
        </div><!-- row -->

    </div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();