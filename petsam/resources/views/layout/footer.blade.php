<!-- Footer Start -->
<footer class="bg-dark text-white py-5 mt-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-paw me-2"></i>PetSam
                </h5>
                <p class="text-muted small">Cung cấp phụ kiện và sản phẩm chăm sóc thú cưng chất lượng cao. Giao hàng nhanh toàn quốc.</p>
            </div>
            <div class="col-md-6 col-lg-3">
                <h5 class="text-primary mb-3">Liên hệ</h5>
                <p class="text-muted small mb-1">
                    <i class="fas fa-map-marker-alt me-2"></i>123 Đường Pet, TP. HCM
                </p>
                <p class="text-muted small mb-1">
                    <i class="fas fa-phone-alt me-2"></i><a href="tel:+84987654321" class="text-decoration-none text-muted">(+84) 987 654 321</a>
                </p>
                <p class="text-muted small">
                    <i class="fas fa-envelope me-2"></i><a href="mailto:support@petsam.vn" class="text-decoration-none text-muted">support@petsam.vn</a>
                </p>
            </div>
            <div class="col-md-6 col-lg-3">
                <h5 class="text-primary mb-3">Thông tin</h5>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Về chúng tôi</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Chính sách đổi trả</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Hướng dẫn mua hàng</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3">
                <h5 class="text-primary mb-3">Theo dõi</h5>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="bg-secondary my-4">
        <div class="row">
            <div class="col-12 text-center text-muted small">
                <p class="mb-0">&copy; 2025 <strong>PetSam</strong>. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- Back to Top Button -->
<a href="#" class="btn btn-primary btn-lg-square back-to-top" style="position: fixed; bottom: 1rem; right: 1rem; display: none; z-index: 99;">
    <i class="fas fa-arrow-up"></i>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTop = document.querySelector('.back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        });
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
