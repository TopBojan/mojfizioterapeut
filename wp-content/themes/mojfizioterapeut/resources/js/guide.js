jQuery(function ($) {
    var $modal = $(".guide-modal");

    if (!$modal.length) {
        return;
    }

    $(document).on("click", ".guide-video-play", function () {
        var id = $(this).data("vimeo");

        if (!id) {
            return;
        }

        $modal.find("iframe").attr(
            "src",
            "https://player.vimeo.com/video/" + id + "?autoplay=1&badge=0&autopause=0&player_id=0&app_id=58479"
        );
        $modal.removeAttr("hidden").addClass("is-open");
        $("body").addClass("locked");
    });

    $modal.on("click", ".guide-modal-close, .guide-modal-backdrop", function () {
        $modal.attr("hidden", "hidden").removeClass("is-open");
        $modal.find("iframe").attr("src", "");
        $("body").removeClass("locked");
    });
});
