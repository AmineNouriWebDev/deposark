jQuery(document).ready(($) => {
  $(".php-email-form").on("submit", function (e) {
    e.preventDefault();

    const form = $(this);
    const formData = new FormData(this);
    formData.append("action", "contact_form");
    formData.append("security", contact_ajax.nonce);

    $.ajax({
      url: contact_ajax.ajaxurl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: () => {
        form.find(".loading").fadeIn();
        form.find(".error-message, .sent-message").fadeOut();
      },
      success: (response) => {
        if (response.success) {
          form.find(".sent-message").fadeIn().delay(3000).fadeOut();
          form.trigger("reset");
        } else {
          form.find(".error-message").html(response.data).fadeIn();
        }
      },
      error: (xhr) => {
        form
          .find(".error-message")
          .html("Erreur technique : " + xhr.statusText)
          .fadeIn();
      },
      complete: () => {
        form.find(".loading").fadeOut();
      },
    });
  });
});
