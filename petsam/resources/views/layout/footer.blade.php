<!-- Footer Start -->
<footer class="text-white py-5 mt-5 bg-primary">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <h5 class="text-white mb-3" style="font-size: 1.5rem; font-weight: 600;">
                    <i class="fas fa-paw me-2"></i>{{ $siteInfo->name }}
                </h5>
                <p class="text-white-50" style="font-size: 1.05rem; line-height: 1.6;">{{ $siteInfo->description }}</p>
            </div>
            <div class="col-md-6 col-lg-4">
                <h5 class="text-white mb-3" style="font-size: 1.5rem; font-weight: 600;">Liên hệ</h5>
                <p class="text-white-50 mb-2" style="font-size: 1.05rem;">
                    <i class="fas fa-map-marker-alt me-2"></i>{{ $siteInfo->address }}
                </p>
                <p class="text-white-50 mb-2" style="font-size: 1.05rem;">
                    <i class="fas fa-phone-alt me-2"></i><a href="tel:{{ str_replace(' ', '', $siteInfo->phone) }}" class="text-decoration-none text-white-50">{{ $siteInfo->phone }}</a>
                </p>
                <p class="text-white-50" style="font-size: 1.05rem;">
                    <i class="fas fa-envelope me-2"></i><a href="mailto:{{ $siteInfo->email }}" class="text-decoration-none text-white-50">{{ $siteInfo->email }}</a>
                </p>
            </div>

            <div class="col-md-6 col-lg-4">
                <h5 class="text-white mb-3" style="font-size: 1.5rem; font-weight: 600;">Theo dõi</h5>
                <div class="d-flex gap-2 flex-wrap">
                    @if($siteInfo->facebook_url)
                        <a href="{{ $siteInfo->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-light"><i class="fab fa-facebook"></i></a>
                    @else
                        <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-facebook"></i></a>
                    @endif
                    
                    @if($siteInfo->twitter_url)
                        <a href="{{ $siteInfo->twitter_url }}" target="_blank" class="btn btn-sm btn-outline-light"><i class="fab fa-twitter"></i></a>
                    @else
                        <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-twitter"></i></a>
                    @endif
                    
                    @if($siteInfo->instagram_url)
                        <a href="{{ $siteInfo->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-light"><i class="fab fa-instagram"></i></a>
                    @else
                        <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-instagram"></i></a>
                    @endif
                    
                    @if($siteInfo->youtube_url)
                        <a href="{{ $siteInfo->youtube_url }}" target="_blank" class="btn btn-sm btn-outline-light"><i class="fab fa-youtube"></i></a>
                    @else
                        <a href="#" class="btn btn-sm btn-outline-light"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <hr class="bg-light-50 my-4" style="background-color: rgba(255, 255, 255, 0.2) !important;">
        <div class="row">
            <div class="col-12 text-center small" style="color: rgba(255, 255, 255, 0.7);">
                <p class="mb-2">&copy; 2025 <strong style="color: #fff;">{{ $siteInfo->name }}</strong>. All rights reserved.</p>
                <p class="mb-1"><small>Đồ án thực tập chuyên ngành</small></p>
                <p class="mb-1"><small>Sinh viên: <strong style="color: #fff;">Nguyễn Văn Tuấn Anh</strong> | MSSV: <strong style="color: #fff;">DH52200334</strong></small></p>
                <p class="mb-0"><small>Liên hệ: <a href="tel:0798561413" class="text-decoration-none" style="color: #ffd700; font-weight: bold;">0798561413</a></small></p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->



<!-- Back to Top Button -->
<a href="#" class="btn btn-primary btn-lg-square back-to-top" style="position: fixed; bottom: 1rem; right: 1rem; display: none; z-index: 10;">
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
