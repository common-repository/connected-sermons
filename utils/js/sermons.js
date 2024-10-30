(function ($) {
  $(document).ready(function () {
    cmb_checker = setInterval(function () {
      if ($(".cmb2-id-cs-media-type").length) {
        update_media_type();
        clearInterval(cmb_checker);
      }
    }, 100);

    $("#cs_media_type").change(function () {
      update_media_type();
    });

    update_media_type = () => {
      hide_all();
      switch ($("#cs_media_type option:selected").val()) {
        case "youtube":
          $(".cmb2-id-cs-youtube-url").show();
          break;
        case "facebook":
          $(".cmb2-id-cs-facebook-embed").show();
          break;
        case "vimeo":
          $(".cmb2-id-cs-vimeo-embed").show();
          break;
        case "embed_code":
          $(".cmb2-id-cs-embed-code").show();
          break;
        case "url":
          $(".cmb2-id-cs-source-url").show();
          break;
        case "mp3":
          $(".cmb2-id-cs-mp3").show();
          break;
        default:
          break;
      }
    };

    hide_all = () => {
      $(
        ".cmb2-id-cs-youtube-url, .cmb2-id-cs-facebook-embed, .cmb2-id-cs-vimeo-embed, .cmb2-id-cs-embed-code, .cmb2-id-cs-source-url, .cmb2-id-cs-mp3"
      ).hide();
    };

    menu_highlighter = () => {
      pages = [
        "edit.php?post_type=cs_sermons",
        "edit-tags.php?taxonomy=cs_books",
        "edit-tags.php?taxonomy=cs_preachers",
        "edit-tags.php?taxonomy=cs_series",
        "edit-tags.php?taxonomy=cs_topics",
      ];

      pages.map((page) => {
        if ($(location).attr("href").indexOf(page) >= 0) {
          $("#toplevel_page_connected-sermons").addClass(
            " current wp-has-current-submenu "
          );
        }
      });
    };

    constructor = () => {
      menu_highlighter();
    };

    constructor();
  });
})(jQuery);
