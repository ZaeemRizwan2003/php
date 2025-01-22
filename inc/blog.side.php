<!-- /widget -->
<div class="widget">
    <div class="widget-title">
        <h4>Letzte Beiträge</h4>
    </div>
    <ul class="comments-list">
        <?php
            // Fetching the latest 4 blog posts
            $sideBlogs = $con->query("SELECT * FROM the_blog ORDER BY blog_id DESC LIMIT 4");

            // Check if the query was successful
            if ($sideBlogs->num_rows > 0) {
                while ($sideBlog = $sideBlogs->fetch_object()) {
        ?>
        <li>
            <small><?= timeTR($sideBlog->created_at) ?></small>
            <h3><a href="text/<?= $sideBlog->slug ?>/<?= $sideBlog->blog_id ?>" title=""><?= htmlspecialchars($sideBlog->name) ?></a></h3>
        </li>
        <?php 
                }
            } else {
                echo "<li>No posts found.</li>";
            }
        ?>
    </ul>
</div>
<!-- /widget -->

<div class="widget">
    <div class="widget-title">
        <h4>Blog Kategorie</h4>
    </div>
    <ul class="cats">
        <?php
            // Fetching all blog categories
            $sideBlogKats = $con->query("SELECT * FROM the_blog_category ORDER BY category_id DESC");

            // Check if the query was successful
            if ($sideBlogKats->num_rows > 0) {
                while ($sideBlogKat = $sideBlogKats->fetch_object()) {
        ?>
            <li><a href="blog/kategori/<?= $sideBlogKat->slug ?>/<?= $sideBlogKat->category_id ?>"><?= htmlspecialchars($sideBlogKat->name) ?></a></li>
        <?php 
                }
            } else {
                echo "<li>No categories found.</li>";
            }
        ?>
    </ul>
</div>
<!-- /widget -->
