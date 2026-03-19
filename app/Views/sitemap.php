<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc><?= base_url() ?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc><?= base_url('portfolio') ?></loc>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?= base_url('store') ?></loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
    </url>

    <!-- Categories -->
    <?php foreach ($categories as $category): ?>
    <url>
        <loc><?= base_url('category/' . $category['slug']) ?></loc>
        <priority>0.7</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>

    <!-- Posts -->
    <?php foreach ($posts as $post): ?>
    <url>
        <loc><?= base_url($post['slug']) ?></loc>
        <?php
            // Use updated_at, or published_at, or fallback to current time
            $lastmod = !empty($post['updated_at']) ? $post['updated_at'] : (!empty($post['published_at']) ? $post['published_at'] : (!empty($post['created_at']) ? $post['created_at'] : date('Y-m-d H:i:s')));
        ?>
        <lastmod><?= date('c', strtotime($lastmod)) ?></lastmod>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>

    <!-- Portfolios -->
    <?php foreach ($portfolios as $portfolio): ?>
    <url>
        <loc><?= base_url($portfolio['slug']) ?></loc>
        <?php
            $lastmod = !empty($portfolio['updated_at']) ? $portfolio['updated_at'] : (!empty($portfolio['created_at']) ? $portfolio['created_at'] : date('Y-m-d H:i:s'));
        ?>
        <lastmod><?= date('c', strtotime($lastmod)) ?></lastmod>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>
    <?php endforeach; ?>

    <!-- Products -->
    <?php foreach ($products as $product): ?>
    <url>
        <loc><?= base_url($product['slug']) ?></loc>
        <?php
            $lastmod = !empty($product['updated_at']) ? $product['updated_at'] : (!empty($product['created_at']) ? $product['created_at'] : date('Y-m-d H:i:s'));
        ?>
        <lastmod><?= date('c', strtotime($lastmod)) ?></lastmod>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>
</urlset>
