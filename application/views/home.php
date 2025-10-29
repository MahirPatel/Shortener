<!doctype html>
<html lang="en">
  <head>
    <title>Shorten URLs - Track Everything</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            color: #e2e8f0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
        }
        
        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem 0;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideInUp 1s ease-out;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 1.5rem;
            animation: slideInUp 1s ease-out 0.2s both;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.6;
            animation: slideInUp 1s ease-out 0.4s both;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .url-shortener-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 20px;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideInUp 1s ease-out 0.6s both;
            transition: all 0.3s ease;
        }
        
        .url-shortener-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.4);
        }
        
        .url-shortener-card .row {
            align-items: center;
        }
        
        @media (max-width: 767px) {
            .url-shortener-card .col-md-8,
            .url-shortener-card .col-md-4 {
                margin-bottom: 1rem;
            }
            
            .url-shortener-card .col-md-4 {
                margin-bottom: 0;
            }
        }
        
        .form-control {
            background: rgba(15, 23, 42, 0.8);
            border: 2px solid rgba(148, 163, 184, 0.2);
            border-radius: 12px;
            color: #e2e8f0;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            height: calc(2.7em + .75rem + 2px)
        }
        
        .form-control:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            color: #e2e8f0;
        }
        
        .form-control::placeholder {
            color: #64748b;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: auto;
            min-height: 54px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .result-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 20px;
            padding: 2rem;
            max-width: 800px;
            margin: 2rem auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideInUp 0.5s ease-out;
        }
        
        .result-item {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .result-item:hover {
            background: rgba(15, 23, 42, 0.8);
            border-color: rgba(148, 163, 184, 0.2);
        }
        
        .result-label {
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .result-value {
            color: #e2e8f0;
            word-break: break-all;
        }
        
        .result-value a {
            color: #60a5fa;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .result-value a:hover {
            color: #93c5fd;
        }
        
        .copy-btn {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            margin-left: 1rem;
            transition: all 0.3s ease;
        }
        
        .copy-btn:hover {
            background: rgba(34, 197, 94, 0.2);
            color: #16a34a;
        }
        
        .platforms_container {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(148, 163, 184, 0.2);
        }
        
        .platform-label {
            color: #94a3b8;
            font-size: 12px;
            margin-bottom: 8px;
        }
        
        .features-section {
            padding: 5rem 0;
            background: rgba(15, 23, 42, 0.3);
        }
        
        .features-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .features-subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 4rem;
        }
        
        .feature-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            animation: slideInUp 1s ease-out;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border-color: rgba(148, 163, 184, 0.2);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: #94a3b8;
            line-height: 1.6;
        }
        
        .footer {
            background: rgba(15, 23, 42, 0.8);
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            padding: 2rem 0;
            text-align: center;
            color: #64748b;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.25rem;
            }
            
            .url-shortener-card {
                margin: 0 1rem 3rem;
                padding: 1.5rem;
            }
            
            .result-card {
                margin: 2rem 1rem;
                padding: 1.5rem;
            }
        }
        
        .loading {
            position: relative;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
  </head>
  <body>
    <div class="animated-bg"></div>
    <section class="hero-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <h1 class="hero-title">Shorten <span style="color: #e2e8f0;">URLs</span></h1>
            <h2 class="hero-subtitle">Track Everything</h2>
            <p class="hero-description">
              Transform long URLs into powerful, trackable links. Get detailed analytics,
              QR codes, and lightning-fast redirects for all your shortened URLs.
            </p>
            
            <div class="url-shortener-card">
              <div class="row">
                <div class="col-md-8">
                  <input type="text" class="form-control" id="url_link" placeholder="Paste your long URL here..." aria-label="Enter URL">
                </div>
                <div class="col-md-4">
                  <button type="button" id="shorten_url" class="btn btn-primary btn-block">
                    <span class="btn-text">Shorten URL</span>
                  </button>
                </div>
              </div>
            </div>
            
            <div class="result_card" style="display: none;">
              <div class="result-card">
                <div class="d-flex align-items-center mb-3">
                  <i class="fas fa-check-circle text-success mr-2"></i>
                  <h5 class="mb-0" style="color: #22c55e;">Shortened URL</h5>
                </div>
                
                <div class="result-item short_link_container">
                  <div class="result-label">Shortened URL</div>
                  <div class="result-value d-flex align-items-center justify-content-between">
                    <span class="short_link"></span>
                    <button class="btn copy-btn" onclick="copyToClipboard()">
                      <i class="fas fa-copy mr-1"></i>
                    </button>
                  </div>
                </div>
                
                <div class="result-item">
                  <div class="result-label">Original URL</div>
                  <div class="result-value original_link"></div>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="result-item">
                      <div class="result-label d-flex align-items-center justify-content-between">
                        <span>Total Clicks</span>
                        <button class="btn copy-btn">
                          <span class="result-value clicks">0</span>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="result-item">
                      <div class="result-label d-flex align-items-center justify-content-between">
                        <span>QR Code</span>
                        <button class="btn copy-btn qr_code_btn">
                          <i class="fas fa-qrcode mr-1"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="result-item platforms_container" style="display: none;">
                  <div class="result-label">Platform Analytics</div>
                  <div class="result-value platforms"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="features-section">
      <div class="container">
        <h2 class="features-title">Powerful Features</h2>
        <p class="features-subtitle">Everything you need to manage and track your links</p>
        
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-link"></i>
              </div>
              <h3 class="feature-title">Smart URL Shortening</h3>
              <p class="feature-description">
                Create clean, memorable short links that are easy to share across all platforms and social media.
              </p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-chart-bar"></i>
              </div>
              <h3 class="feature-title">Advanced Analytics</h3>
              <p class="feature-description">
                Track clicks, QR based redirection data, referrer sources, and user behavior with detailed real-time analytics.
              </p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-bolt"></i>
              </div>
              <h3 class="feature-title">Lightning Fast</h3>
              <p class="feature-description">
                Instant redirects with 99.9% uptime. Your users will experience seamless, lightning-fast navigation.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <footer class="footer">
      <div class="container">
        <p>&copy; Created by Mahir Patel 2025</p>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        var base_url = "<?php echo base_url(); ?>";
        var shortUrl = '';
        
        $(function () {
            // Add smooth scrolling
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top
                    }, 1000);
                }
            });
            
            // Enhanced URL shortening with animations
            $('#shorten_url').click(function (e) { 
                e.preventDefault();
                var url = $('#url_link').val().trim();    
                
                if(!url) {
                    showNotification('Please enter a valid URL', 'error');
                    return;
                }
                
                // Basic URL validation
                if(!isValidUrl(url)) {
                    showNotification('Please enter a valid URL (include http:// or https://)', 'error');
                    return;
                }
                
                $.ajax({
                    type: "post",
                    url: "Home/create",
                    data: {url : url},
                    dataType: "json",
                    beforeSend: function(){
                        $('#shorten_url').prop('disabled', true);
                        $('#shorten_url').addClass('loading');
                        $('.btn-text').text('Processing...');
                        $('#url_link').attr('readonly', true);
                    },
                    success: function (response) {
                        if(response && typeof response === 'object'){
                            var original_link = response['original_link'];
                            var short_link = response['short_link'];
                            var clicks = response['clicks'];
                            var platforms = response['clicksfrom'];
                            
                            shortUrl = short_link;
                            
                            // Update result display with animations
                            $('.original_link').html(`<a target="_blank" href="${original_link}">${truncateUrl(original_link, 60)}</a>`);
                            $('.short_link').html(`<a target="_blank" id="hash_link" href="${short_link}">${short_link}</a>`);
                            $('.clicks').text(clicks);
                            
                            // Handle platform analytics
                            if(platforms && platforms !== '') {
                                try {
                                    var platformsArr = JSON.parse(platforms);
                                    if(platformsArr && platformsArr['platform']) {
                                        var platformList = '';
                                        for (let key in platformsArr['platform']) {
                                            if (platformsArr['platform'].hasOwnProperty(key)) {
                                                platformList += `<span class="badge badge-secondary mr-2 mb-2">${key}: ${platformsArr['platform'][key]}</span>`;
                                            }
                                        }
                                        $('.platforms').html(platformList);
                                        $('.platforms_container').show();
                                    }
                                } catch(e) {
                                    $('.platforms_container').hide();
                                }
                            } else {
                                $('.platforms_container').hide();
                            }
                            
                            // Show result with animation
                            $(".result_card").fadeIn(500);
                            
                            // Scroll to result
                            $('html, body').animate({
                                scrollTop: $(".result_card").offset().top - 100
                            }, 800);
                            
                            showNotification('URL shortened successfully!', 'success');
                        } else {
                            showNotification('Error shortening URL. Please try again.', 'error');
                        }
                    },
                    complete: function() {
                        $('#shorten_url').prop('disabled', false);
                        $('#shorten_url').removeClass('loading');
                        $('.btn-text').text('Shorten URL');
                        $('#url_link').attr('readonly', false);
                    },
                    error: function() {
                        showNotification('Network error. Please check your connection.', 'error');
                    }
                });
            });
            
            // Enhanced QR code download
            $(document).on('click', '.qr_code_btn', function (e) {
                e.preventDefault();
                let url = $('#hash_link').attr('href');
                
                if (url) {
                    if (url.startsWith('http://')) {
                        url = url.replace('http://', 'https://');
                    }
                    
                    let full_url = base_url + 'Home/download_qr_code?url=' + encodeURIComponent(url);
                    window.location.href = full_url;
                    showNotification('QR Code download started!', 'success');
                } else {
                    showNotification('No URL available for QR code generation', 'error');
                }
            });
            
            // Enter key support
            $('#url_link').keypress(function(e) {
                if(e.which == 13) {
                    $('#shorten_url').click();
                }
            });
        });
        
        // Copy to clipboard function
        function copyToClipboard() {
            var shortLink = $('#hash_link').attr('href');
            if (shortLink) {
                navigator.clipboard.writeText(shortLink).then(function() {
                    showNotification('URL copied to clipboard!', 'success');
                    
                    // Visual feedback
                    $('.copy-btn').html('<i class="fas fa-check mr-1"></i> Copied!');
                    setTimeout(function() {
                        $('.copy-btn').html('<i class="fas fa-copy mr-1"></i> Copy');
                    }, 2000);
                }).catch(function() {
                    // Fallback for older browsers
                    var textArea = document.createElement("textarea");
                    textArea.value = shortLink;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    showNotification('URL copied to clipboard!', 'success');
                });
            }
        }
        
        // URL validation function
        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                // Try adding protocol
                try {
                    new URL('http://' + string);
                    return true;
                } catch (_) {
                    return false;
                }
            }
        }
        
        // Truncate URL for display
        function truncateUrl(url, maxLength) {
            if (url.length <= maxLength) return url;
            return url.substring(0, maxLength) + '...';
        }
        
        // Notification system
        function showNotification(message, type) {
            // Remove existing notifications
            $('.notification').remove();
            
            var bgColor = type === 'success' ? '#22c55e' : '#ef4444';
            var icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            var notification = $(`
                <div class="notification" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${bgColor};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                    z-index: 9999;
                    display: flex;
                    align-items: center;
                    font-weight: 500;
                    animation: slideInRight 0.3s ease-out;
                ">
                    <i class="${icon} mr-2"></i>
                    ${message}
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
        
        // Add CSS for notification animation
        $('<style>').text(`
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `).appendTo('head');
    </script>
  </body>
</html>