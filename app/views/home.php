<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <h2 style="color: #b55656;">Danh mục câu hỏi</h2>
            <p <?php
                if ($data["cateActive"] == -1) {
                    echo " style=\"background-color:moccasin;\"";
                }
                ?>>
                <a href="<?php echo _WEB_ROOT . "/Home/index/" . "-1/" . $data["Page"]; ?>">
                    <b>Tất cả</b>
                </a>
            </p>
            <?php
            if (isset($data["Categories"]) && count($data["Categories"]) > 0) {
                foreach ($data["Categories"] as $category) { ?>
                    <p <?php
                        if ($data["cateActive"] == $category["category_id"]) {
                            echo " style=\"background-color:moccasin;\"";
                        }
                        ?>>
                        <a href="<?php echo _WEB_ROOT . "/Home/index/" . $category["category_id"] . "/" . $data["Page"]; ?>">
                            <b><?php echo trim($category["name"]); ?></b>
                        </a>
                    </p>
            <?php }
            }
            ?>
        </div>
        <div class="col-sm-10">
            
        </div>
    </div>
</div>