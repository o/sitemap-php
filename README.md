**For the 90's people, i'm keeping this repository as 5.2 compatible. If you need PSR-0 and Composer compatible version, [here is a fork that maintained by Evert Pot](https://github.com/evert/sitemap-php).**

What is sitemap-php ?
----------

Fast and lightweight class for generating Google sitemap XML files and index of sitemap files. Written on PHP and uses XMLWriter extension (wrapper for libxml xmlWriter API) for creating XML files. XMLWriter extension is enabled by default in PHP 5 >= 5.1.2. If you having more than 50000 url, it splits items to seperated files. _(In benchmarks, 1.000.000 url was generating in 8 seconds)_

How to use
----------

Include Sitemap.php file to your PHP document and call Sitemap class with your base domain.

	include 'Sitemap.php';
	$sitemap = new Sitemap('http://example.com');	

Now, we need to define path for saving XML files. This can be relative like `xmls` or absolute `/path/to/your/folder` and *must be a writable folder*. In default it uses same folder with your script.

	$sitemap->setPath('xmls/');

Generated XML file names defaulted to `sitemap-*.xml`, you can customize prefix of filenames with `setFilename` method.

	$sitemap->setFilename('customsitemap');

	
We'll add sitemap url's with `addItem` method. In this method, only first parameter (location) is required.

	$sitemap->addItem('/', '1.0', 'daily', 'Today');
	$sitemap->addItem('/about', '0.8', 'monthly', 'Jun 25');
	$sitemap->addItem('/contact', '0.6', 'yearly', '14-12-2009');
	$sitemap->addItem('/otherpage');

w/ method chaining.

	$sitemap->addItem('/projects', '0.8')->addItem('/somepage')->addItem('/hiddenpage', '0.4', 'yearly', '01-01-2011')->addItem('/rss');

from a sql result, or whatever.

	$query = Doctrine_Query::create()
					->select('p.created_at, p.slug')
					->from('Posts p')
					->orderBy('p.id DESC')
					->useResultCache(true);
	$posts =  $query->fetchArray(array(), Doctrine_Core::HYDRATE_ARRAY);
    foreach ($posts as $post) {
        $sitemap->addItem('/post/' . $post['slug'], '0.6', 'weekly', $post['created_at']);
    }

If you need to change domain for sitemap instance, you can override it via `setDomain` method.

	$sitemap->setDomain('http://blog.example.com');
	
Finally we create index for sitemap files. **This method also closes tags of latest generated xml file.**

	$sitemap->createSitemapIndex('http://example.com/sitemap/', 'Today');
	
When you run your script, it generates and saves XML files to given path.

sitemap-0.xml

	<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	 <url>
	  <loc>http://example.com/</loc>
	  <priority>1.0</priority>
	  <changefreq>daily</changefreq>
	  <lastmod>2011-04-07</lastmod>
	 </url>
	 <url>
	  <loc>http://example.com/about</loc>
	  <priority>0.8</priority>
	  <changefreq>monthly</changefreq>
	  <lastmod>2011-06-25</lastmod>
	 </url>
	 <url>
	  <loc>http://example.com/contact</loc>
	  <priority>0.6</priority>
	  <changefreq>yearly</changefreq>
	  <lastmod>2009-12-14</lastmod>
	 </url>
	 <url>
	  <loc>http://example.com/otherpage</loc>
	  <priority>0.5</priority>
	 </url>
	</urlset>
	
sitemap-index.xml

	<?xml version="1.0" encoding="UTF-8"?>
	<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	 <sitemap>
	  <loc>http://example.com/sitemap/sitemap-0.xml</loc>
	  <lastmod>2011-04-07</lastmod>
	 </sitemap>
	</sitemapindex>
	
You need to submit sitemap-index.xml to Google Sitemaps.

**Please note that, generating sitemaps not overrides any previous generated sitemap file. You need to delete old files before the operation.**

	$ rm -rv sitemap-*

For the truncating a file with php, use the following snippet:

	$handle = fopen("/path/to/sitemap/file.xml", "w");
	fclose($handle);
