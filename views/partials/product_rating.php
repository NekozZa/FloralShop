<small class="text-primary mr-2"><?= $product['AvgRating'] ? number_format($product['AvgRating'], 1, '.', '') : 0 ?></small>
<?php for ($i = 1; $i <= 5; $i++) { ?>
    <?php if ($i <= $product['AvgRating']) { ?>
        <small class="fa fa-star text-primary mr-1"></small>
    <?php } else { ?>
        <small class="far fa-star text-primary mr-1"></small>
    <?php } ?>
<?php } ?>
<small>(<?= $product['CountReviews'] ?>)</small>