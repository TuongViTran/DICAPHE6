$(document).ready(function () {
    $(".save-btn").click(function () {
        var shopId = $(this).data("shop-id");
        var button = $(this); // Nút hiện tại

        $.ajax({
            url: "/coffeeshop/favorite/" + shopId, // URL gửi request
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"), // Lấy CSRF token từ meta tag
            },
            success: function (response) {
                var icon = button.find(".save-icon");
                var text = button.find(".save-text");

                if (response.status == "saved") {
                    text.text("Đã Lưu");
                    button.addClass("liked"); // Thêm class 'liked' để thay đổi màu sắc
                } else {
                    text.text("Lưu");
                    button.removeClass("liked"); // Loại bỏ class 'liked'
                }
                alert(response.message);
            },
            error: function (xhr, status, error) {
                console.error("Request failed:", error);
            },
        });
    });
});
