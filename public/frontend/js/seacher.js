// function updateSliderValue(slider) {
//     let valueLabel = slider.nextElementSibling;
//     valueLabel.textContent = slider.value + (slider.max == 15 ? 'km' : 'k');
// }
// document.querySelectorAll('.dropdown-btn').forEach(button => {
//     button.addEventListener('click', function() {
//         let content = this.nextElementSibling;
//         if (content.classList.contains('active')) {
//             content.style.maxHeight = '0';
//             content.style.opacity = '0';
//             setTimeout(() => content.classList.remove('active'), 300);
//         } else {
//             content.classList.add('active');
//             content.style.maxHeight = content.scrollHeight + 'px';
//             content.style.opacity = '1';
//         }
//     });
// });

// function updateSliderValue(slider) {
//     let valueLabel = slider.nextElementSibling;
//     valueLabel.textContent = slider.value + (slider.max == 15 ? 'km' : 'k');
// }

// document.querySelectorAll('.dropdown-btn').forEach(button => {
//     button.addEventListener('click', function(e) {
//         e.stopPropagation(); // Ngăn đóng khi click vào nút

//         let content = this.nextElementSibling;

//         // Đóng các dropdown khác nếu cần
//         document.querySelectorAll('.dropdown-content.active').forEach(drop => {
//             if (drop !== content) {
//                 drop.classList.remove('active');
//                 drop.style.maxHeight = '0';
//                 drop.style.opacity = '0';
//             }
//         });

//         if (content.classList.contains('active')) {
//             content.classList.remove('active');
//             content.style.maxHeight = '0';
//             content.style.opacity = '0';
//         } else {
//             content.classList.add('active');
//             content.style.maxHeight = content.scrollHeight + 'px';
//             content.style.opacity = '1';
//         }
//     });
// });

// // Đóng dropdown nếu click bên ngoài
// document.addEventListener('click', function(e) {
//     document.querySelectorAll('.dropdown-content.active').forEach(content => {
//         content.classList.remove('active');
//         content.style.maxHeight = '0';
//         content.style.opacity = '0';
//     });
// // });


document.querySelectorAll('.dropdown-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.stopPropagation();

        let content = this.nextElementSibling;

        document.querySelectorAll('.dropdown-content.active').forEach(drop => {
            if (drop !== content) {
                drop.classList.remove('active');
                drop.style.maxHeight = '0';
                drop.style.opacity = '0';
            }
        });

        if (content.classList.contains('active')) {
            // Tạo hiệu ứng đóng mượt
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            setTimeout(() => {
                content.classList.remove('active');
            }, 400); // Trùng với transition time
        } else {
            content.classList.add('active');
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
        }
    });
});

document.addEventListener('click', function(e) {
    document.querySelectorAll('.dropdown-content.active').forEach(content => {
        content.style.maxHeight = '0';
        content.style.opacity = '0';
        setTimeout(() => {
            content.classList.remove('active');
        }, 700); // Cho phép animation chạy xong
    });
});