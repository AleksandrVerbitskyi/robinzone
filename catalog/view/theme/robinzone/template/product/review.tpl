<?php if ($reviews) { ?>
    <?php foreach ($reviews as $review) { ?>
        <div class="feedback">
            <div class="feedback_title">
                <div class="cover"><p class="stars stars_cover" data-stars="<?= $review['rating'] ?>">
                        <svg height="25" width="23" class="star rating" data-rating="1">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                        <svg height="25" width="23" class="star rating" data-rating="2">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                        <svg height="25" width="23" class="star rating" data-rating="3">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                        <svg height="25" width="23" class="star rating" data-rating="4">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                        <svg height="25" width="23" class="star rating" data-rating="5">
                            <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                        </svg>
                    </p></div>
                <div class="cover"><p class="feedback_name"><?= $review['author']; ?></p></div>
                <p class="feedback_date"><?= $review['date_added']; ?></p>
            </div>
            <p class="feedback_content"><?= $review['text']; ?></p>
        </div>
    <?php } ?>
    <div class="text-right"><?= $pagination; ?></div>
<?php } else { ?>
    <p><?= $text_no_reviews; ?></p>
<?php } ?>