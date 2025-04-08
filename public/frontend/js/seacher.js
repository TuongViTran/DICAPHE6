function updateSliderValue(slider) {
    let valueLabel = slider.nextElementSibling;
    valueLabel.textContent = slider.value + (slider.max == 15 ? 'km' : 'k');
}
document.querySelectorAll('.dropdown-btn').forEach(button => {
    button.addEventListener('click', function() {
        let content = this.nextElementSibling;
        if (content.classList.contains('active')) {
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            setTimeout(() => content.classList.remove('active'), 300);
        } else {
            content.classList.add('active');
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
        }
    });
});