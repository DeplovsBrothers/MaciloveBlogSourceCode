server {
  #listen on port 80 of localhost
  listen 80;
  index index.html index.php;
  error_page 404 = /404.html;
  charset utf-8;

  client_max_body_size 10M;

  gzip on;
  gzip_vary on;
  #gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript text/x-js;
  gzip_comp_level 9;  
  
  gzip_types text/plain text/css application/json application/x-javascript text/xml
  application/xml application/rss+xml text/javascript image/svg+xml
  application/vnd.ms-fontobject application/x-font-ttf font/opentype;



#####################################################

	rewrite ^/news/apple-news$  /news/apple-news/ permanent;
	rewrite ^/news/(apple-news)/$ /index.php?categories=$1 last;
	   
	rewrite ^/news/apple-accessories-reviews$  /news/apple-accessories-reviews/ permanent;
        rewrite ^/news/(apple-accessories-reviews)/$ /index.php?categories=$1 last;

	rewrite ^/news/ios-games/$ /news/games-for-ios/ permanent;
        rewrite ^/news/ios-apps/$ /news/apps-for-ios/ permanent;
        rewrite ^/news/mac-apps/$ /news/apps-for-mac-os-x/ permanent;
        rewrite ^/news/tricks/$ /news/secrets-mac-os-x/ permanent;

	rewrite ^/news/games-for-ios$ /news/games-for-ios/ permanent;
        rewrite ^/news/(games-for-ios)/$ /index.php?categories=$1 last;	

	rewrite ^/news/games-for-iphone$ /news/games-for-iphone/ permanent;
	rewrite ^/news/(games-for-iphone)/$ /index.php?categories=$1 last;
	
        rewrite ^/news/games-for-ipad$ /news/games-for-ipad/ permanent;
        rewrite ^/news/(games-for-ipad)/$ /index.php?categories=$1 last;

	rewrite ^/news/apps-for-ios$ /news/apps-for-ios/ permanent;
        rewrite ^/news/(apps-for-ios)/$ /index.php?categories=$1 last;

	rewrite ^/news/apps-for-iphone$ /news/apps-for-iphone/ permanent;
	rewrite ^/news/(apps-for-iphone)/$ /index.php?categories=$1 last;

	rewrite ^/news/apps-for-ipad$ /news/apps-for-ipad/ permanent;
        rewrite ^/news/(apps-for-ipad)/$ /index.php?categories=$1 last;

	rewrite ^/news/apps-and-games-for-mac-os-x$ /news/apps-and-games-for-mac-os-x/ permanent;
        rewrite ^/news/(apps-and-games-for-mac-os-x)/$ /index.php?categories=$1 last;
	 
	rewrite ^/news/apps-for-mac-os-x$ /news/apps-for-mac-os-x/ permanent;
	rewrite ^/news/(apps-for-mac-os-x)/$ /index.php?categories=$1 last;
	 
	rewrite ^/news/games-for-mac-os-x$ /news/games-for-mac-os-x/ permanent;
        rewrite ^/news/(games-for-mac-os-x)/$ /index.php?categories=$1 last;

	rewrite ^/news/tricks-and-secrets-mac-os-x-ios$ /news/tricks-and-secrets-mac-os-x-ios/ permanent;
        rewrite ^/news/(tricks-and-secrets-mac-os-x-ios)/$ /index.php?categories=$1 last;

	rewrite ^/news/secrets-iphone-ipad$ /news/secrets-iphone-ipad/ permanent;
	rewrite ^/news/(secrets-iphone-ipad)/$ /index.php?categories=$1 last;
	 
        rewrite ^/news/secrets-mac-os-x$ /news/secrets-mac-os-x/ permanent;
        rewrite ^/news/(secrets-mac-os-x)/$ /index.php?categories=$1 last;

	rewrite ^/news/apple-news/page/([0-9]+)$ /news/apple-news/page/$1/ permanent;
	rewrite ^/news/(apple-news)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;
	 
	rewrite ^/news/games-for-ios/page/([0-9]+)$ /news/games-for-ios/page/$1/ permanent;
        rewrite ^/news/(games-for-ios)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/games-for-iphone/page/([0-9]+)$ /news/games-for-iphone/page/$1/ permanent;
	rewrite ^/news/(games-for-iphone)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;
	 
	rewrite ^/news/games-for-ipad/page/([0-9]+)$ /news/games-for-ipad/page/$1/ permanent;
        rewrite ^/news/(games-for-ipad)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/apps-for-ios/page/([0-9]+)$ /news/apps-for-ios/page/$1/ permanent;
        rewrite ^/news/(apps-for-ios)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/apps-for-iphone/page/([0-9]+)$ /news/apps-for-iphone/page/$1/ permanent;
	rewrite ^/news/(apps-for-iphone)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;
	 
	rewrite ^/news/apps-for-ipad/page/([0-9]+)$ /news/apps-for-ipad/page/$1/ permanent;
        rewrite ^/news/(apps-for-ipad)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/apps-and-games-for-mac-os-x/page/([0-9]+)$ /news/apps-and-games-for-mac-os-x/page/$1/ permanent;
        rewrite ^/news/(apps-and-games-for-mac-os-x)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/apps-for-mac-os-x/page/([0-9]+)$ /news/apps-for-mac-os-x/page/$1/ permanent;
	rewrite ^/news/(apps-for-mac-os-x)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;
	 
	rewrite ^/news/games-for-mac-os-x/page/([0-9]+)$ /news/games-for-mac-os-x/page/$1/ permanent;
        rewrite ^/news/(games-for-mac-os-x)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/tricks-and-secrets-mac-os-x-ios/page/([0-9]+)$ /news/tricks-and-secrets-mac-os-x-ios/page/$1/ permanent;
        rewrite ^/news/(tricks-and-secrets-mac-os-x-ios)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/news/secrets-iphone-ipad/page/([0-9]+)$ /news/secrets-iphone-ipad/page/$1/ permanent;
	rewrite ^/news/(secrets-iphone-ipad)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;
	 
	rewrite ^/news/secrets-mac-os-x/page/([0-9]+)$ /news/secrets-mac-os-x/page/$1/ permanent;
        rewrite ^/news/(secrets-mac-os-x)/page/([0-9]+)/$ /index.php?categories=$1&page=$2 last;

	rewrite ^/subscribe-by-email$ /subscribe-by-email/ permanent;
        rewrite ^/subscribe-by-email/$ /subscribe-by-email.php last;

	rewrite ^/registration$ /registration/ permanent;
	rewrite ^/registration/$ /registration.php last;
	 
	rewrite ^/best-mac-os-x-apps$ /best-mac-os-x-apps/ permanent;
	rewrite ^/best-mac-os-x-apps/$ /best-apps/best-apps.php?type=mac-os-x last;
	
	rewrite ^/os-x-wallpapers$ /os-x-wallpapers/ permanent;
	rewrite ^/os-x-wallpapers/$ /os-x-wallpapers.html last;	 

	rewrite ^/best-mac-os-x-games$ /best-mac-os-x-games/ permanent;
	rewrite ^/best-mac-os-x-games/$ /best-apps/best-apps.php?type=mac-os-x-games last; 

	rewrite ^/best-iphone-and-ipad-games$ /best-iphone-and-ipad-games/ permanent;
	rewrite ^/best-iphone-and-ipad-games/$ /best-iphone-and-ipad-games.html last;
	
	rewrite ^/about$ /about/ permanent;
	rewrite ^/about/$ /about.html last;
	
	rewrite ^/use-of-cookies$ /use-of-cookies/ permanent;
        rewrite ^/use-of-cookies/$ /use-of-cookies.html last;

	rewrite ^/live$ /live/ permanent;
	rewrite ^/live/$ /live.php last;

	rewrite ^/live/page/([0-9]+)$ /live/page/$1/ permanent;
        rewrite ^/live/page/([0-9]+)/$ /live.php?page=$1 last;

	rewrite ^/login$ /login/ permanent;
	rewrite ^/login/$ /login.php last;
	 
	rewrite ^/feedback$ /feedback/ permanent;
	rewrite ^/feedback/$ /feedback.html last;
		
	rewrite ^/lost_password$ /lost_password/ permanent;
	rewrite ^/lost_password/$ /lost_password.php last;
	
	rewrite ^/live_add$ /live_add/ permanent;
	rewrite ^/live_add/$ /live_add.php last;

	rewrite ^/questions/ask$ /questions/ask/ permanent;
	rewrite ^/questions/ask/$ /questions/ask.php last;

	rewrite ^/questions/ask/([0-9]+)$ /questions/ask/$1/ permanent;
	rewrite ^/questions/ask/([0-9]+)/$ /questions/ask.php?url=$1 last;

	rewrite ^/questions/([A-Za-z0-9_-]+)$ /questions/$1/ permanent;
	rewrite ^/questions/([A-Za-z0-9_-]+)/$ /questions/index.php?category=$1 last;

	rewrite ^/questions/question/([0-9]+)$ /questions/question/$1/ permanent;
	rewrite ^/questions/question/([0-9]+)/$ /questions/question.php?q_id=$1 last;
	 
	rewrite ^/news/([A-Za-z0-9_-]+)$ /news/$1/ permanent;
	rewrite ^/news/([A-Za-z0-9_-]+)/$ /news/content.php?url=$1 last;
		 
	rewrite ^/news/page/([0-9]+)$ /news/page/$1/ permanent;
	rewrite ^/news/page/([0-9]+)/$ /news/index.php?page=$1 last;

	rewrite ^/editor$ /editor/ permanent;
	rewrite ^/editor/$ /editor.php last;



#####


	
	rewrite ^/editor/([a-z0-9_-]+)$ /editor/$1/ permanent;
	rewrite ^/editor/([a-z0-9_-]+)/$ /editor.php?url=$1 last;

	rewrite ^/blue-screen$ /blue-screen/ permanent;
	rewrite ^/blue-screen/$ /blue-screen.php last;
	
	rewrite /404/ /404.html last;
	



########################################################


  # If you need ssl, enable it here and add the certs
  # listen 443 default_server ssl;
  # ssl_certificate /etc/nginx/ssl/example.com.pem;
  # ssl_certificate_key /etc/nginx/ssl/example.com.key;

  # set up a server name - localhost or subdomain.localhost will work for local dev
  server_name macilove.com www.macilove.com;

  #access_log /var/log/sites/macilove.com/access.log;
  #error_log /var/log/sites/macilove.com/error.log;

 # Set the document root
  root /var/www/macilove.com/;

  # Set up our document root to try the URI, as well as any index.php files
  # Also make sure we're passing any query strings along
  location / {
      try_files $uri $uri/ /index.php?$query_string;
  }

  # Set up our PHP handler
  location ~* \.php$ {
      # Pass PHP requests off to FPM on port 9000
      fastcgi_pass    127.0.0.1:9000;
      fastcgi_index   index.php;
      fastcgi_split_path_info ^(.+\.php)(.*)$;
      include /etc/nginx/fastcgi_params;
      fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
  }

  # Deny access to any dot files
  location ~/\. {
	access_log off;
	deny all;
  }

  location ~* ^.+\.(jpg|jpeg|gif|png|ico|css|js|xml)$ {
        access_log   off;
        expires      90d;
  }
}
