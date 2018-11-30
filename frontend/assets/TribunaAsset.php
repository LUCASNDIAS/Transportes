<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TribunaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/eBusiness/lib/bootstrap/css/bootstrap.min.css',
        'vendor/eBusiness/lib/nivo-slider/css/nivo-slider.css',
        'vendor/eBusiness/lib/owlcarousel/owl.carousel.css',
        'vendor/eBusiness/lib/owlcarousel/owl.transitions.css',
        'vendor/eBusiness/lib/font-awesome/css/font-awesome.min.css',
        'vendor/eBusiness/lib/animate/animate.min.css',
        'vendor/eBusiness/lib/venobox/venobox.css',
        'vendor/eBusiness/css/nivo-slider-theme.css',
        'vendor/eBusiness/css/style.css',
        'vendor/eBusiness/css/responsive.css',
        'vendor/eBusiness/',
    ];
    public $js = [
        'vendor/eBusiness/lib/jquery/jquery.min.js',
        'vendor/eBusiness/lib/bootstrap/js/bootstrap.min.js',
        'vendor/eBusiness/lib/owlcarousel/owl.carousel.min.js',
        'vendor/eBusiness/lib/venobox/venobox.min.js',
        'vendor/eBusiness/lib/knob/jquery.knob.js',
        'vendor/eBusiness/lib/wow/wow.min.js',
        'vendor/eBusiness/lib/parallax/parallax.js',
        'vendor/eBusiness/lib/easing/easing.min.js',
        'vendor/eBusiness/lib/nivo-slider/js/jquery.nivo.slider.js',
        'vendor/eBusiness/lib/appear/jquery.appear.js',
        'vendor/eBusiness/lib/isotope/isotope.pkgd.min.js',
        'vendor/eBusiness/contactform/contactform.js',
        'vendor/eBusiness/js/main.js',
    ];
    public $depends = [
    ];
}