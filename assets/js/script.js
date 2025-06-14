/**
 * Ana JavaScript Dosyası
 * 
 * Bu dosya sistemdeki tüm JavaScript fonksiyonlarını ve olay dinleyicilerini içerir.
 * Form validasyonları ve kullanıcı etkileşimleri burada yönetilir.
 */

/**
 * Silme işlemini onaylatma fonksiyonu
 */
function confirmDelete() {
    return confirm('Bu kaydı silmek istediğinize emin misiniz?');
}

// Sayfa yüklendiğinde çalışacak kodlar
document.addEventListener('DOMContentLoaded', function() {
    // Form validasyonlarını yönetme
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            let valid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Lütfen tüm zorunlu alanları doldurun.');
            }
        });
    });
});