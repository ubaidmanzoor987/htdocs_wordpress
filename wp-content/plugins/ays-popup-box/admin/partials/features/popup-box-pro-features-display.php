<div class="wrap">
    <h1 class="wp-heading-inline">
		<?php echo __( esc_html( get_admin_page_title() ), $this->plugin_name ); ?>
    </h1>

    <div class="ays-pb-features-wrap">
        <div class="comparison">
            <table>
                <thead>
                <tr>
                    <th class="tl tl2" style="width: 350px;"></th>
                    <th class="product" style="background:#69C7F1; border-top-left-radius: 5px; border-left:0px;">
                            <span style="display: block">
                                <?php echo __( 'Personal', $this->plugin_name ); ?></span>
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/avatars/personal_avatar.png'; ?>"
                             alt="Free" title="Free" width="100"/>
                    </th>
                    <th class="product" style="background:#69C7F1;">
                            <span style="display: block">
                                <?php echo __( 'Business', $this->plugin_name ); ?></span>
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/avatars/business_avatar.png'; ?>"
                             alt="Business" title="Business" width="100"/>
                    </th>
                    <th class="product" style="border-top-right-radius: 5px; border-right:0px; background:#69C7F1;">
                            <span style="display: block">
                                <?php echo __( 'Developer', $this->plugin_name ); ?></span>
                        <img src="<?php echo AYS_PB_ADMIN_URL . '/images/avatars/pro_avatar.png'; ?>"
                             alt="Developer"
                             title="Developer" width="100"/>
                    </th>
                </tr>
                <tr>
                    <th></th>
                    <th class="price-info">
                        <div class="price-now"><span>
                                    <?php echo __( 'Free', $this->plugin_name ); ?></span></div>
                    </th>
                    <th class="price-info">
                        <div class="price-now"><span>$19</span>
                        </div>
                    </th>
                    <th class="price-info">
                        <div class="price-now"><span>$49</span>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Support for', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Support for', $this->plugin_name ); ?>
                    </td>
                    <td>
						<?php echo __( '1 site', $this->plugin_name ); ?>
                    </td>
                    <td>
						<?php echo __( '5 sites', $this->plugin_name ); ?>
                    </td>
                    <td>
						<?php echo __( 'Unlimited sites', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
		                <?php echo __( 'Upgrade for', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Upgrade for', $this->plugin_name ); ?>
                    </td>
                    <td>
		                <?php echo __( '1 months', $this->plugin_name ); ?>
                    </td>
                    <td>
		                <?php echo __( '12 months', $this->plugin_name ); ?>
                    </td>
                    <td>
		                <?php echo __( 'Lifetime', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
		                <?php echo __( 'Support for', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Support for', $this->plugin_name ); ?>
                    </td>
                    <td>
		                <?php echo __( '1 months', $this->plugin_name ); ?>
                    </td>
                    <td>
		                <?php echo __( '12 months', $this->plugin_name ); ?>
                    </td>
                    <td>
		                <?php echo __( 'Lifetime', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
						<?php echo __( 'Usage for lifetime', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
						<?php echo __( 'Usage for lifetimes', $this->plugin_name ); ?>
                    </td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
						<?php echo __( 'Session time option', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
						<?php echo __( 'Session time option', $this->plugin_name ); ?>
                    </td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
		                <?php echo __( 'Responsive design', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
		                <?php echo __( 'Responsive design', $this->plugin_name ); ?>
                    </td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
						<?php echo __( 'Scroll from top', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Scroll from top', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="3">
		                <?php echo __( 'Styles', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Styles', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Display on pages', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Display on pages', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Delay', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Delay', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Open with click', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Open with click', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
						<?php echo __( 'Custom content', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
						<?php echo __( 'Custom content', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
		                <?php echo __( 'Popup box position', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
		                <?php echo __( 'Popup box position', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Multiple scheduling', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Multiple scheduling', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'PopupBox Reports', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'PopupBox Reports', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Enable for selected user OS', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Enable for selected user OS', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Enable for selected browsers', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Enable for selected browser', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Limitation count', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Limitation count', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Export/Import', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Export/Import', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Close by scrolling down', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Close by scrolling down', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Close by classname', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Close by classname', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Actions while clicking on the popup', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Actions while clicking on the popup', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <?php echo __( 'Title style', $this->plugin_name ); ?>
                    </td>
                </tr>
                <tr class="compare-row">
                    <td>
                        <?php echo __( 'Title style', $this->plugin_name ); ?>
                    </td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                    <td><i class="ays_fa ays_fa-check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td><a href="https://wordpress.org/plugins/popup-box/" class="price-buy">
							<?php echo __( 'Download', $this->plugin_name ); ?><span class="hide-mobile"></span></a>
                    </td>
                    <td><a href="https://ays-pro.com/index.php/wordpress/popup-box" class="price-buy">
							<?php echo __( 'Buy now', $this->plugin_name ); ?><span class="hide-mobile"></span></a></td>
                    <td><a href="https://ays-pro.com/index.php/wordpress/popup-box" class="price-buy">
							<?php echo __( 'Buy now', $this->plugin_name ); ?><span class="hide-mobile"></span></a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>