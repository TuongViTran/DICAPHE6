document.addEventListener("DOMContentLoaded", function () {
    // Xử lý form tạo bài viết
    const createForm = document.getElementById("createPostForm");
    if (createForm) {
        handleAjaxForm(createForm, "create");
    }

    // Xử lý tất cả form chỉnh sửa bài viết
    const editForms = document.querySelectorAll('[id^="editPostForm"]');
    editForms.forEach((form) => {
        handleAjaxForm(form, "edit");
    });

    // Hàm xử lý form gửi Ajax
    function handleAjaxForm(form, type) {
        form.addEventListener("submit", async function (e) {
            e.preventDefault(); // Chặn submit truyền thống

            // Cập nhật CKEditor nội dung trước khi gửi
            if (typeof CKEDITOR !== "undefined") {
                for (let instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }

            const formData = new FormData(form);

            // Phương thức được sử dụng cho việc tạo hay cập nhật
            const method = type === "edit" ? "POST" : "POST"; // 🛠 PUT cần _method spoofing ở backend
            if (type === "edit") {
                formData.append("_method", "PUT"); // Thêm _method=PUT nếu là edit
            }

            try {
                const response = await fetch(form.action, {
                    method: method,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'input[name="_token"]'
                        ).value,
                    },
                    body: formData,
                });

                if (!response.ok) {
                    if (response.status === 422) {
                        const data = await response.json();
                        showErrors(form, data.errors); // Hiển thị lỗi validate
                    } else {
                        const errorText = await response.text();
                        console.error("Server error:", errorText);
                        alert(
                            "Có lỗi xảy ra trên server. Vui lòng thử lại sau!"
                        );
                    }
                } else {
                    const data = await response.json();
                    alert(
                        data.message ||
                            (type === "create"
                                ? "Tạo bài viết thành công!"
                                : "Cập nhật bài viết thành công!")
                    );

                    // Đóng modal sau khi xử lý thành công
                    const modal = bootstrap.Modal.getInstance(
                        form.closest(".modal")
                    );
                    if (modal) {
                        modal.hide();
                    }

                    // Reload lại trang hoặc load lại danh sách bài viết
                    location.reload();
                }
            } catch (error) {
                console.error("Lỗi fetch:", error);
                alert(
                    "Không thể kết nối tới server. Vui lòng kiểm tra lại mạng!"
                );
            }
        });
    }

    // Hàm hiển thị lỗi (nếu có)
    function showErrors(form, errors) {
        // Xóa lỗi cũ
        form.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());
        form.querySelectorAll(".is-invalid").forEach((el) =>
            el.classList.remove("is-invalid")
        );

        // Duyệt qua các lỗi và hiển thị lên các trường tương ứng
        for (const [field, messages] of Object.entries(errors)) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add("is-invalid"); // Thêm class is-invalid

                const div = document.createElement("div");
                div.classList.add("invalid-feedback");
                div.innerText = messages[0]; // Lấy thông báo lỗi đầu tiên

                // Nếu input nằm trong form-group hoặc input-group, thêm lỗi vào sau
                if (input.parentNode) {
                    input.parentNode.appendChild(div);
                }
            }
        }
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-post-form");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            const confirmed = confirm(
                "Bạn có chắc chắn muốn xóa bài viết này không?"
            );
            if (!confirmed) {
                e.preventDefault(); // Nếu không đồng ý thì chặn submit
            }
        });
    });
});
