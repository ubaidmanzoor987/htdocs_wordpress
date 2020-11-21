<?php

//if accessed directly exit
if(!defined('ABSPATH')) exit;

class SelectSkin extends BazaarQodefSkinAbstract {
    /**
     * Skin constructor. Hooks to bazaar_qodef_admin_scripts_init and bazaar_qodef_enqueue_admin_styles
     */
	public function __construct() {
		$this->skinName = 'select';

        //hook to admin register scripts
        add_action('bazaar_qodef_admin_scripts_init', array($this, 'registerStyles'));
        add_action('bazaar_qodef_admin_scripts_init', array($this, 'registerScripts'));

        //hook to admin enqueue scripts
        add_action('bazaar_qodef_enqueue_admin_styles', array($this, 'enqueueStyles'));
        add_action('bazaar_qodef_enqueue_admin_scripts', array($this, 'enqueueScripts'));

        add_action('bazaar_qodef_enqueue_meta_box_styles', array($this, 'enqueueStyles'));
        add_action('bazaar_qodef_enqueue_meta_box_scripts', array($this, 'enqueueScripts'));

		add_action( 'admin_enqueue_scripts', array( $this, 'setShortcodeJSParams' ), 5 ); 
	}

    /**
     * Method that registers skin scripts
     */
    public function registerScripts() {
        $this->scripts['bootstrap.min'] = 'assets/js/bootstrap.min.js';
        $this->scripts['jquery.nouislider.min'] = 'assets/js/qodef-ui/jquery.nouislider.min.js';
        $this->scripts['qodef-ui-admin'] = 'assets/js/qodef-ui/qodef-ui.js';
        $this->scripts['qodef-bootstrap-select'] = 'assets/js/qodef-ui/qodef-bootstrap-select.min.js';
        $this->scripts['select2'] = 'assets/js/qodef-ui/select2.min.js';

        foreach ($this->scripts as $scriptHandle => $scriptPath) {
            bazaar_qodef_register_skin_script($scriptHandle, $scriptPath);
        }
    }

    /**
     * Method that registers skin styles
     */
    public function registerStyles() {
        $this->styles['qodef-bootstrap'] = 'assets/css/qodef-bootstrap.css';
        $this->styles['qodef-page-admin'] = 'assets/css/qodef-page.css';
        $this->styles['qodef-options-admin'] = 'assets/css/qodef-options.css';
        $this->styles['qodef-meta-boxes-admin'] = 'assets/css/qodef-meta-boxes.css';
        $this->styles['qodef-ui-admin'] = 'assets/css/qodef-ui/qodef-ui.css';
        $this->styles['qodef-forms-admin'] = 'assets/css/qodef-forms.css';
        $this->styles['qodef-import'] = 'assets/css/qodef-import.css';
        $this->styles['font-awesome-admin'] = 'assets/css/font-awesome/css/font-awesome.min.css';
        $this->styles['select2'] = 'assets/css/select2.min.css';

        foreach ($this->styles as $styleHandle => $stylePath) {
            bazaar_qodef_register_skin_style($styleHandle, $stylePath);
        }
    }
    /**
     * Method that renders options page
     *
     * @see SelectSkin::getHeader()
     * @see SelectSkin::getPageNav()
     * @see SelectSkin::getPageContent()
     */
	public function renderOptions() {
        global $bazaar_qodef_Framework;
        $tab    = bazaar_qodef_get_admin_tab();
        $active_page = $bazaar_qodef_Framework->qodeOptions->getAdminPageFromSlug($tab);
        if ($active_page == null) return;
    ?>
        <div class="qodef-options-page qodef-page">
            <?php $this->getHeader(); ?>
            <div class="qodef-page-content-wrapper">
                <div class="qodef-page-content">
                    <div class="qodef-page-navigation qodef-tabs-wrapper vertical left clearfix">
                        <?php $this->getPageNav($tab); ?>
                        <?php $this->getPageContent($active_page); ?>
                    </div>
                </div>
            </div>
        </div>
	<?php }

    /**
     * Method that renders header of options page.
     * @param bool $show_save_btn whether to show save button. Should be hidden on import page
     *
     * @see BazaarQodefSkinAbstract::loadTemplatePart()
     */
    public function getHeader($show_save_btn = true) {
        $this->loadTemplatePart('header', array('show_save_btn' => $show_save_btn));
    }

    /**
     * Method that loads page navigation
     * @param string $tab current tab
     * @param bool $is_import_page if is import page highlighted that tab
     *
     * @see BazaarQodefSkinAbstract::loadTemplatePart()
     */
	public function getPageNav($tab, $is_import_page = false, $is_backup_options_page = false) {
		$this->loadTemplatePart('navigation', array(
			'tab' => $tab,
			'is_import_page' => $is_import_page,
			'is_backup_options_page' => $is_backup_options_page
		));
	}

    /**
     * Method that loads current page content
     *
	 * @param BazaarQodefAdminPage $page current page to load
     *
     * @see BazaarQodefSkinAbstract::loadTemplatePart()
     */
    public function getPageContent($page) {
        $this->loadTemplatePart('content', array('page' => $page));
    }

    /**
     * Method that loads content for import page
     */
    public function getImportContent() {
        $this->loadTemplatePart('content-import');
    }

    /**
     * Method that loads content for backup page
     */
    public function getBackupOptionsContent() {
        $this->loadTemplatePart('backup-options');
    }

    /**
     * Method that loads anchors and save button template part
     *
	 * @param BazaarQodefAdminPage $page current page to load
     *
     * @see QodeSkinAbstract::loadTemplatePart()
     */
    public function getAchorsAndSave($page) {
        $this->loadTemplatePart('anchors-save', array('page' => $page));
    }

    /**
     * Method that renders import page
     *
     * @see SelectSkin::getHeader()
     * * @see SelectSkin::getPageNav()
     * * @see SelectSkin::getImportContent()
     */
    public function renderImport() { ?>
        <div class="qodef-options-page qodef-page">
            <?php $this->getHeader(false); ?>
            <div class="qodef-page-content-wrapper">
                <div class="qodef-page-content">
                    <div class="qodef-page-navigation qodef-tabs-wrapper vertical left clearfix">
                        <?php $this->getPageNav('tabimport', true); ?>
                        <?php $this->getImportContent(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }

	/**
	 * Method that renders backup options page
	 *
	 * @see SelectSkin::getHeader()
	 * * @see SelectSkin::getPageNav()
	 * * @see SelectSkin::getImportContent()
	 */
	public function renderBackupOptions() { ?>
		<div class="qodef-options-page qodef-page">
			<?php $this->getHeader('',false); ?>
			<div class="qodef-page-content-wrapper">
				<div class="qodef-page-content">
					<div class="qodef-page-navigation qodef-tabs-wrapper vertical left clearfix">
						<?php $this->getPageNav('backup_options', false, true); ?>
						<?php $this->getBackupOptionsContent(); ?>
					</div>
				</div>
			</div>
		</div>
	<?php }
}
?>