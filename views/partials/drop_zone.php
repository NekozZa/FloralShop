<?php if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/public/img/shop-$type-$shopID.jpg")) { ?>
    <img class="img-fluid" style="width: 100%" src="/public/img/shop-<?= $type ?>-<?= $shopID ?>.jpg" alt="">
<?php } else if ($_SESSION['Role'] === 'Seller') { ?>
    <div    
        class="w-100 h-100 p-3 d-flex align-items-center drop-zone" 
        onclick="addImage(event, '<?= $type ?>', <?= $shopID ?>)"  
        ondrop="dropImage(event, '<?= $type ?>', <?= $shopID ?>)"
        style="cursor: pointer; <?= $type === 'banner' ? 'border: 1px dashed black' : '' ?>"
    >
        <input type="file" hidden>
        <p class="m-0 w-100 text-center drop-message" style="pointer-events: none"><?= $content ?></p>   
    </div>
<?php } ?>
