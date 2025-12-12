    </main>
    <footer class="site-footer">
      <div class="footer-top">
        <div>
          <p class="footer-title">SaloneHub</p>
          <p class="footer-text">Fast, transparent access to Sierra Leone’s verified government services.</p>
        </div>
        <div>
          <p class="footer-heading">Quick Links</p>
          <div class="footer-links">
            <a href="services.php">Services</a>
            <a href="representatives.php">Representatives</a>
          </div>
        </div>
        <div>
          <p class="footer-heading">Stay Updated</p>
          <p class="footer-text">Subscribe for live updates on service requirements and timelines.</p>
          <div class="footer-form">
            <input type="email" placeholder="Email address" aria-label="Email address">
            <button type="button">Notify me</button>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>Built for citizens & teams. Hackathon-ready MVP.</p>
        <p>Offline-ready • Secure • Transparent</p>
      </div>
    </footer>
</div>
  
  <!-- Google Analytics (replace with your GA tracking ID) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'GA_MEASUREMENT_ID', {
      'custom_map': {'custom_parameter_1': 'service_type'}
    });
    
    // Track service searches
    function trackServiceSearch(query, filters = {}) {
      gtag('event', 'search', {
        'search_term': query,
        'custom_parameter_1': filters.agency || 'all',
        'custom_dimension_1': filters.region || 'all'
      });
    }
    
    // Track representative searches
    function trackRepSearch(district) {
      gtag('event', 'representative_search', {
        'custom_parameter_1': district
      });
    }
  </script>
  
  <script src="assets/js/app.js"></script>
</body>
</html>

