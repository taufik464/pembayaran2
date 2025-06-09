document.getElementById('kelas_awal').addEventListener('change', function() {
    const kelasId = this.value;
    const container = document.getElementById('siswa-container');
    if (!kelasId) {
        container.innerHTML = '';
        return;
    }

    fetch(`/naik-kelas/siswa/${kelasId}`)
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
        });
});

// Checkbox select all
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'checkAll') {
        const checkboxes = document.querySelectorAll('input[name="siswa[]"]');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    }
});
