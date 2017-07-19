<?php

if (!defined('ABSPATH')) die;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active('rewardstyle-widgets/rewardstyle-widgets.php') ) {
	return;
}

function p3_shopthepost_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0',
        'adblock'  => 'Turn off your ad blocker to view content',
        'enableJs' => 'Turn on your JavaScript to view content'
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
                <div class="rs-adblock">
                    <img src="//assets.rewardstyle.com/images/search/350.gif" style="width:15px;height:15px;" onerror="this.parentNode.innerHTML=\''.$adblock.'\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_shopthepost_widget', 'p3_shopthepost_show_widget');

function p3_boutique_show_widget($atts) {
    extract(shortcode_atts(array(
        'id'    => '0',
        'adblock'  => 'Turn off your ad blocker to view content',
        'enableJs' => 'Turn on your JavaScript to view content'
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
                <div class="rs-adblock">
                    <img src="//assets.rewardstyle.com/images/search/350.gif" style="width:15px;height:15px;" onerror="this.parentNode.innerHTML=\''.$adblock.'\'" />
                    <noscript>'.$enableJs.'</noscript>
                </div>
            </div>';
    return $out;
}
add_shortcode('show_boutique_widget', 'p3_boutique_show_widget');