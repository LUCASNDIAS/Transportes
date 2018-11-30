<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class EliasAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/BizPage/lib/bootstrap/css/bootstrap.min.css',
        'vendor/BizPage/lib/font-awesome/css/font-awesome.min.css',
        'vendor/BizPage/lib/animate/animate.min.css',
        'vendor/BizPage/lib/ionicons/css/ionicons.min.css',
        'vendor/BizPage/lib/owlcarousel/assets/owl.carousel.min.css',
        'vendor/BizPage/lib/lightbox/css/lightbox.min.css',
        'vendor/BizPage/css/style.css',
    ];
    public $js = [
        'vendor/BizPage/lib/jquery/jquery.min.js',
        'vendor/BizPage/lib/jquery/jquery-migrate.min.js',
        'vendor/BizPage/lib/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/BizPage/lib/easing/easing.min.js',
        'vendor/BizPage/lib/superfish/hoverIntent.js',
        'vendor/BizPage/lib/superfish/superfish.min.js',
        'vendor/BizPage/lib/wow/wow.min.js',
        'vendor/BizPage/lib/waypoints/waypoints.min.js',
        'vendor/BizPage/lib/counterup/counterup.min.js',
        'vendor/BizPage/lib/owlcarousel/owl.carousel.min.js',
        'vendor/BizPage/lib/isotope/isotope.pkgd.min.js',
        'vendor/BizPage/lib/lightbox/js/lightbox.min.js',
        'vendor/BizPage/lib/touchSwipe/jquery.touchSwipe.min.js',
        'vendor/BizPage/contactform/contactform.js',
        'vendor/BizPage/js/main.js',
    ];
    public $depends = [
    ];
}