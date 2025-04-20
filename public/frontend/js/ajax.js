document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchInput');
    const suggestionList = document.getElementById('suggestionList');

    const typeMap = {
        shop_name: "Tên quán",
        style: "Phong cách",
        price_range: "Khoảng giá",
        keyword_suggestion: "Từ khóa hot"
    };

    input.addEventListener('input', function() {
        const query = input.value.trim();
        if (query.length < 2) {
            suggestionList.style.display = 'none';
            return;
        }

        fetch(`/autocomplete?keyword=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionList.innerHTML = '';

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'list-group-item-action', 'd-flex', 'justify-content-between', 'align-items-center');

                        li.innerHTML = `
                            <span>${item.label}</span>
                            <span class="badge bg-light text-dark">${typeMap[item.type] || item.type}</span>
                        `;

                        li.addEventListener('click', () => {
                            input.value = item.label;
                            suggestionList.style.display = 'none';
                        });

                        suggestionList.appendChild(li);
                    });

                    suggestionList.style.display = 'block';
                } else {
                    suggestionList.style.display = 'none';
                }
            })
            .catch(err => {
                console.error('Lỗi fetch autocomplete:', err);
                suggestionList.style.display = 'none';
            });
    });

    // Chỉ ẩn suggestion nếu không click vào dropdown hoặc input
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !suggestionList.contains(e.target)) {
            suggestionList.style.display = 'none';
        }
    });
});