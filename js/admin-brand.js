jQuery(document).ready(function ($) {
  // Bouton d'upload d'image
  $(".meta-image-button").click(function (e) {
    e.preventDefault();
    var button = $(this);
    var custom_uploader = wp.media({
      title: "Choisir une image",
      library: { type: "image" },
      button: { text: "Utiliser cette image" },
      multiple: false,
    });

    custom_uploader.on("select", function () {
      var attachment = custom_uploader
        .state()
        .get("selection")
        .first()
        .toJSON();
      button.siblings(".meta-image-field").val(attachment.url);
    });

    custom_uploader.open();
  });
});
