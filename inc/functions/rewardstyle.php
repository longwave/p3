<?php

if (!defined('ABSPATH')) die;

if (function_exists('shopthepost_show_widget')) {
	return;
}

function p3_shopthepost_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0'
    ), $atts));

    $out = '<div class="shopthepost-widget" data-widget-id="'.esc_attr($id).'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/shopthepost.js\';
                            d.body.appendChild(e);
                        }
                        if(typeof window.__stp === \'object\') if(d.readyState === \'complete\') {
                            window.__stp.init();
                        }
                    }(document, \'script\', \'shopthepost-script\');
                </script>
            </div>';
    return $out;
}
add_shortcode('show_shopthepost_widget', 'p3_shopthepost_show_widget');

function p3_boutique_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0'
    ), $atts));

    $out = '<div class="boutique-widget" data-widget-id="'.esc_attr($id).'">
                <script type="text/javascript" language="javascript">
                    !function(d,s,id){
                        var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
                        if(!d.getElementById(id)) {
                            e     = d.createElement(s);
                            e.id  = id;
                            e.src = p + \'://widgets.rewardstyle.com/js/boutique.js\';
                            d.body.appendChild(e);
                        }
                        if(typeof window.__boutique === \'object\') if(d.readyState === \'complete\') {
                            window.__boutique.init();
                        }
                    }(document, \'script\', \'boutique-script\');
                </script>
            </div>';
    return $out;
}
add_shortcode('show_boutique_widget', 'p3_boutique_show_widget');