<script>
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('view-pdf-button')) {
            const src = e.target.getAttribute('data-src');
            if (src) {
                window.open(src, '_blank');
            }
        }
    });
</script>
