How to use
----------

Include Sitemap.php file to your PHP document. Call Sitemap class with your base domain. Now you can add new items with addItem method. Only the first method parameter (location) is required.

<pre>
$sitemap = new Sitemap('http://www.osman.gen.tr');
$sitemap->addItem('/', '1.0', 'daily', 'Today');
$sitemap->addItem('/about', '0.8', 'monthly', 'Jun 25');
$sitemap->addItem('/contact', '0.6', 'yearly', '14-12-2009');
$sitemap->addItem('/otherpage');
$sitemap->render();
</pre>

It generates well formed Sitemap XML for using with Google Sitemaps.

<pre>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
 <url>
  <loc>http://www.osman.gen.tr/</loc>
  <priotory>1.0</priotory>
  <changefreq>daily</changefreq>
  <lastmod>2010-06-27</lastmod>
 </url>
 <url>
  <loc>http://www.osman.gen.tr/about</loc>
  <priotory>0.8</priotory>
  <changefreq>monthly</changefreq>
  <lastmod>2010-06-25</lastmod>
 </url>
 <url>
  <loc>http://www.osman.gen.tr/contact</loc>
  <priotory>0.6</priotory>
  <changefreq>yearly</changefreq>
  <lastmod>2009-12-14</lastmod>
 </url>
 <url>
  <loc>http://www.osman.gen.tr/otherpage</loc>
  <priotory>0.5</priotory>
 </url>
</urlset>
</pre>

To do
-----

* Caching output in file, APC Cache and Memcached.
* Splitting sitemaps for each 20000 item.