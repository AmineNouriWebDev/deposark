<?php
/* 
Template Name: Page Contact 
*/
get_header(); ?>

<section id="contact" class="contact section">
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4 mb-5">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-card">
                        <div class="icon-box">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h3>Notre adresse</h3>
                        <p>Tunis- Tunisie</p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-card">
                        <div class="icon-box">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h3>Numéro de contact</h3>
                        <p>Mobile: +216 26 067 067 <br>
                            Email: nouri.webdev@gmail.com</p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-card">
                        <div class="icon-box">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h3>Heures d'ouverture</h3>
                        <p>Lundi- Samedi: 9:00 - 18:00<br>
                            Dimanche: 12:00 - 18:00</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-wrapper" data-aos="fade-up" data-aos-delay="400">
                        <form action="#" method="post" role="form" class="php-email-form">
                            <?php wp_nonce_field('contact_form_nonce', 'security'); ?>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="name" class="form-control" placeholder="Votre nom*" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" placeholder="Adresse Email*" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                        <input type="text" class="form-control" name="phone" placeholder="N° Telephone*" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-list"></i></span>
                                        <select name="subject" class="form-control" required="">
                                            <option value="">Sélectionnez le service*</option>
                                            <option value="Service 1">Consulting</option>
                                            <option value="Service 2">Development</option>
                                            <option value="Service 3">Marketing</option>
                                            <option value="Service 4">Support</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                        <textarea class="form-control" name="message" rows="6" placeholder="Votre message ici*" required=""></textarea>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Votre message a été envoyé. Merci !</div>
                                </div>
                                <div class="text-center">
                                    <button type="submit">Envoyer</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- /Contact Section -->

</section>

<?php get_footer(); ?>