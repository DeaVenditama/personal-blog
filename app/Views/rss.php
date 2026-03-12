<?php echo '<?xml version="1.0" encoding="utf-8"?>' . "\n"; ?>
<rss version="2.0">
    <channel>
        <title>
            <?= $feed_name; ?>
        </title>
        <link>
        <?= $feed_url; ?>
        </link>
        <description>
            <?= $page_description; ?>
        </description>
        <language>
            <?= $page_language; ?>
        </language>
        <pubDate>
            <?= date('r'); ?>
        </pubDate>

        <?php foreach ($posts as $post): ?>
            <item>
                <title>
                    <?= htmlspecialchars($post['title']); ?>
                </title>
                <link>
                <?= base_url($post['slug']); ?>
                </link>
                <guid>
                    <?= base_url($post['slug']); ?>
                </guid>
                <description>
                    <![CDATA[ <?= substr(strip_tags($post['content']), 0, 500) ?>... ]]>
                </description>
                <pubDate>
                    <?= date('r', strtotime($post['published_at'])); ?>
                </pubDate>
            </item>
        <?php endforeach; ?>
    </channel>
</rss>