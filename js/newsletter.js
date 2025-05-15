jQuery(document).ready(($) => {
  $("#newsletter-form").on("submit", function (e) {
    e.preventDefault();
    const form = $(this);
    const messages = {
      loading: form.find(".loading"),
      error: form.find(".error-message"),
      success: form.find(".sent-message"),
    };

    // Réinitialiser les messages
    messages.error.hide().html("");
    messages.success.hide().html("");
    messages.loading.fadeIn();

    // Récupération explicite des données
    const email = form.find('[name="email"]').val().trim();
    const nonce = form.find('[name="newsletter_security"]').val();

    // Validation côté client (optionnelle mais utile)
    if (!email) {
      messages.error.html("L'email est requis").fadeIn();
      messages.loading.fadeOut();
      return;
    }

    $.ajax({
      url: newsletter_ajax.ajaxurl,
      type: "POST",
      data: {
        action: "newsletter_subscription",
        email: email,
        newsletter_security: nonce,
      },
      dataType: "json",
      success: (response) => {
        if (response.success) {
          messages.success.html(response.data).fadeIn();
          form.trigger("reset");
        } else {
          messages.error.html(response.data).fadeIn();
        }
      },
      error: (xhr) => {
        messages.error.html("Erreur réseau : " + xhr.statusText).fadeIn();
      },
      complete: () => {
        messages.loading.fadeOut();
      },
    });
  });
});
