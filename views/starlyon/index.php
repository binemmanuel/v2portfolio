<?php
/**
 * The template file for displaying the home page
 * for the StarLyon theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/theme/starlyon
 * @package Portfolio
 * @version 1.0
 * @since StarLyon 1.0
 */

use portfolio\SiteInfo;

use function portfolio\clean_data;

// Initialize a SiteInfo Object.
$site_info = new SiteInfo;

// Get site informations.
$site_info = $site_info->fetch();

// Include the all sections.
require 'services.php';
require 'portfolio.php';
require 'pricing.php';
require 'about.php';
require 'contact.php';
?>






