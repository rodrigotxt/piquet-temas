<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 */

?>

<script src="https://unpkg.com/vue@3"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const {
    createApp
} = Vue;
createApp({
    data() {
        return {
            message: 'Hello Vue!'
        }
    },
    methods: {

    }
}).mount('#galleryModal')

var formFiltros = Object.assign(...Array.from(document.querySelectorAll('#filtrosBarra form [name]')).map(function(e) {
    let arr = e.name.indexOf('[]') > 0 ? true : false;
    return ({
        [e.name.replace('[]', '')]: arr ? [] : e.value
    })
}));

createApp({
    data() {
        return {
            app: 'Filtros',
            form: formFiltros
        }
    },
    methods: {

    }
}).mount('#filtrosBarra')
</script>

<footer>

    <div class="bootscore-footer pt-5 pb-3">
        <div class="container">

            <!-- Top Footer Widget -->
            <?php if (is_active_sidebar('top-footer')) : ?>
            <div>
                <?php dynamic_sidebar('top footer'); ?>
            </div>
            <?php endif; ?>

            <div class="row">

                <!-- Footer 1 Widget -->
                <div class="col-md-4 col-lg-4">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                    <div>
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Footer 2 Widget -->
                <div class="col-md-4 col-lg-4">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                    <div>
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Footer 3 Widget -->
                <div class="col-md-4 col-lg-4 ultimosImoveis">
                    <h3>Últimos imóveis</h3>
                    <?php $imoveis = getImoveis(4); ?>
                    <?php for ($i = 0; $i < count($imoveis); $i++) {
                        $im = $imoveis[$i];
                        setup_postdata($im);
                    ?>
                    <div class="row mt-3">
                        <div class="col-md-5 mt-2">
                            <?php the_post_thumbnail('medium') ?>
                        </div>
                        <div class="col-md-7 mt-1">
                            <p class="m-0"><?= $im->post_title ?></p>
                            <p class="price m-0"><?= valorMonetario(get_field('valor_do_imovel', $im->ID)) ?></p>
                        </div>
                    </div>
                    <?php }; ?>
                </div>

                <!-- Footer 4 Widget -->
                <!-- 
                <div class="col-md-6 col-lg-3">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                    <div>
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                    <?php endif; ?>
                </div> -->
                <!-- Footer Widgets End -->

            </div>

            <!-- Bootstrap 5 Nav Walker Footer Menu -->
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer-menu',
                'container' => false,
                'menu_class' => '',
                'fallback_cb' => '__return_false',
                'items_wrap' => '<ul id="footer-menu" class="nav %2$s">%3$s</ul>',
                'depth' => 1,
                'walker' => new bootstrap_5_wp_nav_menu_walker()
            ));
            ?>
            <!-- Bootstrap 5 Nav Walker Footer Menu End -->

        </div>
    </div>

    <div class="bootscore-info text-muted py-2 text-center">
        <div class="container border-top">
            <div class="row py-3">
                <div class="col-md-6 text-start">
                    <small>Todos os direitos reservados a Piquet Realty Lda / AMI 16855<br>
                        Resolução Alternativa de Litígios | Livro de Reclamações online | Termos e condições / Política
                        de Privacidade</small>
                </div>
                <div class="col-md-6 text-end">
                    Desenvolvido por <img class="logo-nexus" src="<?= base_url() ?>/img/logo-nexos.svg" alt="">
                </div>
            </div>
            <!-- <small>&copy;&nbsp;<?php echo Date('Y'); ?> - <?php bloginfo('name'); ?></small> -->
        </div>
    </div>

</footer>

<div class="top-button position-fixed zi-1020">
    <a href="#to-top" class="btn btn-primary shadow"><i class="fas fa-chevron-up"></i><span
            class="visually-hidden-focusable">To top</span></a>
</div>

</div><!-- #page -->

<script type="text/javascript">
(function($) {

    /**
     * initMap
     *
     * Renders a Google Map onto the selected jQuery element
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @return  object The map instance.
     */
    function initMap($el) {

        // Find marker elements within map.
        var $markers = $el.find('.marker');

        // Create gerenic map.
        var mapArgs = {
            zoom: $el.data('zoom') || 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map($el[0], mapArgs);

        // Add markers.
        map.markers = [];
        $markers.each(function() {
            initMarker($(this), map);
        });

        // Center map based on markers.
        centerMap(map);

        // Return map instance.
        return map;
    }

    /**
     * initMarker
     *
     * Creates a marker for the given jQuery element and map.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @param   object The map instance.
     * @return  object The marker instance.
     */
    function initMarker($marker, map) {

        // Get position from marker.
        var lat = $marker.data('lat');
        var lng = $marker.data('lng');
        var latLng = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        };

        // Create marker instance.
        var marker = new google.maps.Marker({
            position: latLng,
            map: map
        });

        // Append to reference for later use.
        map.markers.push(marker);

        // If marker contains HTML, add it to an infoWindow.
        if ($marker.html()) {

            // Create info window.
            var infowindow = new google.maps.InfoWindow({
                content: $marker.html()
            });

            // Show info window when marker is clicked.
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
        }
    }

    /**
     * centerMap
     *
     * Centers the map showing all markers in view.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   object The map instance.
     * @return  void
     */
    function centerMap(map) {

        // Create map boundaries from all map markers.
        var bounds = new google.maps.LatLngBounds();
        map.markers.forEach(function(marker) {
            bounds.extend({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
        });

        // Case: Single marker.
        if (map.markers.length == 1) {
            map.setCenter(bounds.getCenter());

            // Case: Multiple markers.
        } else {
            map.fitBounds(bounds);
        }
    }

    // Render maps on page load.
    $(document).ready(function() {
        $('.acf-map').each(function() {
            var map = initMap($(this));
        });
    });

})(jQuery);

function youtube_parser(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    var match = url.match(regExp);
    return (match && match[7].length == 11) ? match[7] : false;
}

function openModal(type = 'video', params = null, post = null) {
    var modal = new bootstrap.Modal(document.getElementById('defaultModal'));
    var modalGallery = new bootstrap.Modal(document.getElementById('galleryModal'));

    switch (type) {
        case 'video':
            openVideoModal(params);
            modal.toggle();
            break;
        case 'gallery':
            openGalleryModal(params, post);
            modalGallery.toggle();

        default:
            break;
    }
}

function openGalleryModal(params, post) {
    axios.post('?getApi=1&a=showSlides', {
            "p": params
        })
        .then(res => {
            let r = res.data;
            console.log('r', r);
            let el = document.querySelector('#galleryModal .galeria');
            el.innerHTML = res.data;
        });
    console.log('Open Gallery..', params, post);
}

function openVideoModal(url) {
    var iframe = document.getElementById('playerModal');
    iframe.src = 'https://www.youtube.com/embed/' + youtube_parser(url) + '?autoplay=1';
    iframe.classList.remove('d-none');
}
</script>
<?php wp_footer(); ?>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    {{message}}
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="container modal-content">
            <div class="row">
                <div class="col-md-9 galeria p-0">
                    GALERIA GALERIA GALERIA
                </div>
                <div class="col-md-3">
                    <div class="container p-2">
                        <h4 class="my-3">Santa Rita Residences</h4>
                        <p class="my-3">Agende sua Visita</p>
                        <input type="text" class="form-control mt-2" name="nome" placeholder="Nome">
                        <input type="email" class="form-control mt-2" name="email" placeholder="Email">
                        <input type="text" class="form-control mt-2" name="telefone" placeholder="Telefone">
                        <textarea class="form-control mt-2" name="mensagem" id="" cols="30" rows="5"
                            placeholder="Mensagem"></textarea>
                        <button class="btn btn-danger w-100 my-3">Contactar</button>
                        <div class="row gx-3 p-1 justify-content-around">
                            <button class="col-md-5 btn border border-dark"><i class="fas fa-phone"></i> Ligar</button>
                            <button class="col-md-6 btn border border-dark"><i class="fab fa-whatsapp"></i>
                                Whatsapp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" modal fade" id="defaultModal" tabindex="-1" aria-hiddhead <div class="modal-content bg-black">
    <iframe class="d-none" id="playerModal" type="text/html" style="margin: 0 auto;" src="about:blank"
        frameborder="0" />
</div>
</div>
</div>

</body>

</html>