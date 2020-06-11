<?php
/**
 * The contact section of the Default StarLyon Theme
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/theme/starlyon
 * @package Portfolio
 * @version 1.0
 * @since StarLyon 1.0
 */
use function portfolio\clean_data;
?>
<!-- .contact -->
<section class="contact" id="contact" data-page="contact me">
    <h2>Contact Me</h2>

    <!-- .contact-modal -->
    <div class="contact-modal">
        <?php if (!empty($_SESSION['response']['error'])): ?>
            <p class="alert-error"><?= clean_data($_SESSION['response']['message']) ?></p>

        <?php elseif (!empty($_SESSION['response']['message'])): ?>
            <p class="alert-success"><?= clean_data($_SESSION['response']['message']) ?></p>
        <?php endif ?>

        <!-- .grid -->
        <div class="grid">
            <form action="contact/send" method="POST">
                <!-- .grid -->
                <div class="grid">
                    <input type="text" name="email" placeholder="Email" 'required'
                    <?php if (
                        !empty($_SESSION['response']) &&
                        $_SESSION['response']['type'] === 'email'
                        
                    ): ?>
                        class="input-error"

                    <?php elseif (
                        !empty($_SESSION['response']) &&
                        !empty($_SESSION['response']['filled_data']['email'])
                    ): ?>
                        value="<?= clean_data($_SESSION['response']['filled_data']['email']) ?>"

                    <?php endif ?>/>

                    <input type="text" name="subject" placeholder="Subject" 'required'
                    <?php if (
                        !empty($_SESSION['response']) &&
                        $_SESSION['response']['type'] === 'subject'

                    ): ?>
                        class="input-error"

                    <?php elseif (
                        !empty($_SESSION['response']) &&
                        !empty($_SESSION['response']['filled_data']['subject'])
                    ): ?>
                        value="<?= clean_data($_SESSION['response']['filled_data']['subject']) ?>"

                    <?php endif ?>/>
                </div>
                <!-- .grid /-->

                <textarea name="message" cols="30" rows="10" placeholder="Message" 'required'
                <?php if (
                        !empty($_SESSION['response']) &&
                        $_SESSION['response']['type'] === 'message'
                ): ?>
                    class="input-error"
                <?php endif ?>><?php if (!empty($_SESSION['response']['filled_data']['message'])): ?><?= clean_data($_SESSION['response']['filled_data']['message']) ?><?php endif ?></textarea>

                <!-- .btn-container -->
                <div class="btn-container">
                    <button class="btn contact-btn"><!--<i class="fa fa-spinner"></i>--> Send</button>
                </div>
                <!-- .btn-container /-->
            </form>
            
            <!-- .contact-details -->
            <div class="contact-details">
                <ul>
                    <li>
                        <i class="fa fa-phone"></i><span>+(234) 818 190 4389</span>
                    </li>
                    <li>
                        <i class="fa fa-map-marker"></i><span>3rd Avenue, Gwarinpa, FCT Abuja, Nigeria</span>
                    </li>
                    <li>
                        <i class="fa fa-envelope-o"></i><span><?= $site_info->email ?></span>
                    </li>
                </ul>
            
                <!-- .map -->
                <!-- <div class="map" id="map"></div> -->
                <!-- <script 
                    async
                    defer 
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe48UWjcCK8q8IEt6ScCP7EMX2zLjRl3k&callback=initMap"></script> -->
                <!-- .map /-->
            </div>
            <!-- .contact-details /-->
        </div>
        <!-- .grid /-->
    </div>
    <!-- .contact-modal /-->
</section>
<!-- .contact /-->

<?php unset($_SESSION['response']) ?>