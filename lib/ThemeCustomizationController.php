<?php
/**
 * Copyright (c) 2021. Geniem Oy
 */

namespace TMS\Theme\Filharmonia;

use TMS\Theme\Base\Interfaces\Controller;
use WP_post;

/**
 * Class ThemeCustomizationController
 *
 * @package TMS\Theme\Filharmonia
 */
class ThemeCustomizationController implements Controller {

    /**
     * Add hooks and filters from this controller
     *
     * @return void
     */
    public function hooks() : void {
        add_filter(
            'tms/theme/header/colors',
            \Closure::fromCallable( [ $this, 'header_colors' ] ),
            10,
            1
        );

        add_filter(
            'tms/theme/footer/colors',
            \Closure::fromCallable( [ $this, 'footer_colors' ] ),
            10,
            1
        );

        add_filter(
            'tms/theme/share_links/link_class',
            fn() => 'has-background-primary-invert'
        );

        add_filter(
            'tms/theme/share_links/icon_class',
            fn() => 'is-black'
        );

        add_filter(
            'tms/theme/accent_colors',
            [ $this, 'get_theme_accent_colors' ]
        );

        add_filter(
            'tms/theme/search/search_item',
            [ $this, 'search_classes' ]
        );

        add_filter(
            'tms/theme/base/search_result_item',
            [ $this, 'alter_search_result_item' ]
        );

        add_filter(
            'tms/theme/event/hero_info_classes',
            fn() => 'has-colors-tertiary'
        );

        add_filter( 'tms/theme/event/group_title', function () {
            return [
                'title' => 'has-background-tertiary',
                'icon'  => 'is-accent',
            ];
        } );

        add_filter( 'tms/theme/event/info_group_classes', fn() => '' );
    }

    /**
     * Customize header colors.
     *
     * @param array $colors Color classes.
     *
     * @return array Array of customized colors.
     */
    public function header_colors( $colors ) : array {
        $colors['search_button']             = 'is-secondary-invert is-outlined';
        $colors['nav']['container']          = 'has-background-secondary';
        $colors['fly_out_nav']['inner']      = 'has-background-secondary has-text-secondary-invert';
        $colors['fly_out_nav']['close_menu'] = 'is-black';
        $colors['lang_nav']['link']          = 'has-border-radius-50';
        $colors['lang_nav']['link__default'] = 'has-text-secondary-invert';
        $colors['lang_nav']['link__active']  = 'has-background-secondary-invert has-text-primary-invert';

        return $colors;
    }

    /**
     * Customize footer colors.
     *
     * @param array $colors Color classes.
     *
     * @return array Array of customized colors.
     */
    public function footer_colors( $colors ) : array {
        $colors['container']   = 'has-background-secondary has-text-secondary-invert';
        $colors['back_to_top'] = 'is-secondary-invert is-outlined';
        $colors['link']        = 'has-text-secondary-invert';
        $colors['link_icon']   = 'is-black';

        return $colors;
    }

    /**
     * Set grid item color scheme.
     *
     * @return string
     */
    public function set_grid_item_color() {
        return 'secondary';
    }

    /**
     * Theme accent colors for layouts
     *
     * @return string[]
     */
    public function get_theme_accent_colors() : array {
        return [
            'has-colors-primary'          => 'Punaoranssi (valkoinen teksti)',
            'has-colors-accent-secondary' => 'Harmaa (musta teksti)',
        ];
    }

    /**
     * Search classes.
     *
     * @param array $classes Search view classes.
     *
     * @return array
     */
    public function search_classes( $classes ) : array {
        $classes['search_item']          = 'has-border-1 has-border-primary';
        $classes['search_form_button']   = 'is-secondary-invert is-outlined';
        $classes['event_search_section'] = 'has-border-bottom-1 has-border-top-1 has-border-divider-invert';

        return $classes;
    }

    /**
     * Get theme accent color by key
     *
     * @param string $key Accent color key.
     *
     * @return string|null
     */
    public function get_theme_accent_color_by_key( string $key ) : ?string {
        $map = $this->get_theme_accent_colors();

        return $map[ $key ] ?? null;
    }

    /**
     * Alter search result item
     *
     * @param WP_Post $post_item Instance of \WP_Post.
     *
     * @return WP_post
     */
    public function alter_search_result_item( $post_item ) {
        $post_item->content_type = false;

        return $post_item;
    }
}
