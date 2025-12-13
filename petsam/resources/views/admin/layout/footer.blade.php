<footer class="footer mt-auto py-4 bg-light border-top">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">
        <small class="text-muted">
          &copy; 2025 <strong>PetSam Admin</strong>. All rights reserved.
        </small>
      </div>
    </div>
  </div>
</footer>

<script>
  // Scroll to top button
  const scrollBtn = document.querySelector('.scroll-to-top');
  window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
      if (scrollBtn) scrollBtn.style.display = 'block';
    } else {
      if (scrollBtn) scrollBtn.style.display = 'none';
    }
  });
</script>
