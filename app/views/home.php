<div class="container-fluid text-center" style="background-color: #cccccc">
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
                foreach ($data["Categories"] as $category) {
                    if ($category["status"] != 0) {
            ?>
                        <p <?php
                            if ($data["cateActive"] == $category["category_id"]) {
                                echo " style=\"background-color:moccasin;\"";
                            }
                            ?>>
                            <a href="<?php echo _WEB_ROOT . "/Home/index/" . $category["category_id"] . "/" . $data["Page"]; ?>">
                                <b><?php echo trim($category["name"]); ?></b>
                            </a>
                        </p>
            <?php  }
                }
            }
            ?>
        </div>
        <div class="col-sm-7" style=" text-align: left; margin:0px  0px; padding:1% 30px">
            <div class="row">
                <div class="card" style="width: 100%;height: auto;overflow: hidden;padding: 1%;background-color: #fff;border-radius: 5px;box-shadow: 1% ">
                    <div class="card-body" style="padding:1%">
                        <div class="row" style="text-align: center; font-size: 30px">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <b>Bạn có điều khúc mắc? Hãy đặt câu hỏi ngay để nhận được đáp án của mình.</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <?php if (!isset($_SESSION["jwt"])) {
                                    echo '<a href="' . _WEB_ROOT . '/login" style="width:100%">';
                                } ?>
                                <button style="width:100%;background-color: #db9b00;padding: 12px;text-align: center;color: #fff;border-radius: 5px;text-transform: uppercase;font-weight: 700;margin-top:3%" <?php if (isset($_SESSION["jwt"])) {
                                                                                                                                                                                                                    echo 'data-toggle="modal" data-target="#makequestion"';
                                                                                                                                                                                                                } ?>><img src="https://hoidap247.com/static/img/icon-question.png" style="margin-right:2%">Đặt câu hỏi</button>
                                <?php if (!isset($_SESSION["jwt"])) {
                                    echo "</a>";
                                } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- DS CAU HOI -->
                <?php
                if (isset($data["tagname"])) { ?>
                    <b style="margin:20px 0; display:block">Tìm kiếm theo Tag:
                        <b style="color: #3ece1b;"> <?php echo $data["tagname"]; ?></b>
                    </b>
                <?php
                }
                ?>
                <?php
                if (isset($data["Questions"]) && count($data["Questions"]) > 0) {
                    foreach ($data["Questions"] as $question) { ?>
                        <div class="card question-card" style="width: 100%;height: auto;overflow: hidden;padding: 1%;background-color: #fff;border-radius: 5px;box-shadow: 1%; margin-top:2% ">
                            <div class="card-body" style="padding:1%">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="<?php if ($question["image"] != null) {
                                                        echo $question["image"];
                                                    } else {
                                                        echo _PUBLIC . '/images/User.png';
                                                    }  ?>" height="40px" width="40px" style="background-color: transparent;margin-top: -5px; border-radius: 50%;">
                                    </div>
                                    <div class="col-md-9">
                                        <b style="font-size: 20px;">
                                            <?php echo $question["username"] ?> </b>
                                        <p><?php echo $question["created"] ?> </p>
                                        <b><?php echo $question["category_name"] ?> </b>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <p><?php echo $question["description"] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <?php if (isset($question["tags"]) && count($question["tags"]) > 0) {
                                        foreach ($question["tags"] as $tag) { ?>
                                            <form method="POST" action="<?php echo _WEB_ROOT . "/Home/SearchByTag/tagname/1" ?>">
                                                <input name="tagname" value="<?php echo $tag["DESCRIPTION"]; ?>" hidden />
                                                <button name="submitSearchTagName" type="submit" class="col-md-1 btn" style="padding:1%; background-color: #028317; color: white;width: auto; margin-right:1%">
                                                    <?php echo $tag["DESCRIPTION"]; ?>
                                                </button>
                                            </form>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-9">
                                        <button style="margin-left:9%; margin-top: 15px;" type="button" class="btn btn-info" onclick="window.location.href='<?php echo _WEB_ROOT . '/questions/' . $question['id_question']; ?>'">Trả lời >></button>
                                    </div>
                                    <div>
                                        <p style="text-align: center;font-size: 15px;">
                                            <span style="color:#00000000"><?php echo $question["id_question"] ?></span>
                                            <span id="likes_of_<?php echo $question["id_question"] ?>"><?php echo $question["likes"] ?></span>
                                            <button type="submit" id="like_ans_<?php echo $question["id_question"] ?>" class="like_ques" style="border: none;background-color: #4CAF5000;"><span style="margin-left:1%;margin-right:1%; " class="glyphicon glyphicon-thumbs-up">
                                                </span></button>
                                            <span id="answers_of_<?php echo $question["id_question"] ?>"><?php echo $question["comment"] ?></span>
                                            <span class="glyphicon glyphicon-comment"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                <?php }
                } else {
                    echo "<h1 style='color:#225f9e;'>Không có kết quả</h1>";
                }
                ?>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if (isset($data["TotalPages"])) {
                        for ($x = 1; $x <= $data["TotalPages"]; $x++) {
                            if ($x == $data["Page"]) {
                                echo ' <li class="active " ><a>' . $x . ' </a></li>';
                            } else {
                                echo ' <li><a href="' . _WEB_ROOT . '/Home/index/' . $data["cateActive"] . '/' . $x . '">' . $x . ' </a></li>';
                            }
                        }
                    }
                    ?>


                </ul>
            </nav>

        </div>
        <div class="col-sm-3" style="text-align: left; padding:1%">
            <?php if (isset($_SESSION["jwt"])) { ?>
                <div class="card" style="width: 100%;height: auto;overflow: hidden;padding: 1%;background-color: #fff;border-radius: 5px;box-shadow: 1% ">
                    <div class="card-body" style="padding:2%">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?php echo $data["user_profile"]["image"] ? $data["user_profile"]["image"] : _PUBLIC . "/images/User.png"  ?>" height="40px" width="40px" style="background-color: transparent;margin-top: 5px; border-radius: 10%;">
                            </div>
                            <div class="col-md-9" style="margin-left:3%">
                                <div class="row">
                                    <b style="font-size: 16px;"><?php echo $data["user_profile"]['name'] ?></b>
                                    <p style="font-size: 12px;"><?php echo $data["user_profile"]['email'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:2%">
                            <p class="col-md-12" style="font-size: 15px;">Số câu hỏi: <b><?php echo $data["user_profile"]['ques'] ?></b></p>
                            <p class="col-md-12" style="font-size: 15px;">Số câu trả lời: <b><?php echo $data["user_profile"]['answer'] ?></b></p>
                            <p class="col-md-12" style="font-size: 15px;"></span><b>Thứ hạng (Tháng): </b> <b style="font-size: 20px; color:#db9b00"> <?php echo $data["user_profile"]['top'] ?></b> <span style="margin-left:1%;margin-right:1%; " class="glyphicon glyphicon-signal"></p>
                            <p class="col-md-12" style="color:#db9b00;text-align: center;">Hãy tích cực trả lời câu hỏi để tăng thứ hạng của mình bạn nhé!!</p>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="card" style="width: 100%;height: auto;overflow: hidden;padding: 1%;background-color: #00000000;border-radius: 5px;box-shadow: 1%; margin-top: 2% ">
                <div class="card-body" style="padding:2%">
                    <div style="text-align: center; font-size: 20px;color:#db9b00;">
                        <a href="<?php echo _WEB_ROOT . "/Home/Ranking" ?>" style="color:#db9b00; margin-bottom:3%"><B>THÀNH VIÊN HĂNG HÁI NHẤT</B></a>
                    </div>
                    <?php if (isset($data["Top"]) && count($data["Top"]) > 0) {
                        foreach ($data["Top"] as $to) { ?>
                            <div class="row" style="vertical-align: middle;">
                                <div class="col-md-2">
                                    <img src=" <?php if ($to["image"] != null) {
                                                    echo $to['image'];
                                                } else {
                                                    echo _PUBLIC . "/images/User.png";
                                                } ?>" height="40px" width="40px" style="background-color: transparent;margin-top: 5px; border-radius: 10%;">
                                </div>
                                <div class="col-md-7" style="padding-top:5%;padding-bottom:2%; ">
                                    <a href="<?php echo _WEB_ROOT . "/userProfile/" . $to["id_user"] ?>" style="color:black;text-decoration: none;" alt="<?php echo $to['name'] ?>">
                                        <p style="font-size: 14px;"><?php echo $to['name'] ?></p>
                                    </a>
                                </div>
                                <div class="col-md-3" style="text-align: right; padding-top:5%;padding-bottom:2%;">
                                    <b style="font-size: 12px;"><?php echo $to['answer'] ?> Câu</b>
                                </div>

                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <div class="card" style="width: 100%;height: auto;overflow: hidden;padding: 1%;background-color: #00000000;border-radius: 5px;box-shadow: 1%; margin-top: 2%">
                <div class="card-body" style="padding:2%">
                    <div style="text-align: center; font-size: 20px;">
                        <B>Bạn muốn hỏi điều gì?</B>
                    </div>
                    <?php if (!isset($_SESSION["jwt"])) {
                        echo '<a href="' . _WEB_ROOT . '/login" style="width:100%">';
                    } ?>
                    <button style="width:100%;background-color: #db9b00;padding: 12px;text-align: center;color: #fff;border-radius: 5px;text-transform: uppercase;font-weight: 700;margin-top:3%" <?php if (isset($_SESSION["jwt"])) {
                                                                                                                                                                                                        echo 'data-toggle="modal" data-target="#makequestion"';
                                                                                                                                                                                                    } ?>><img src="https://hoidap247.com/static/img/icon-question.png" style="margin-right:2%">Đặt câu hỏi</button>
                    <?php if (!isset($_SESSION["jwt"])) {
                        echo "</a>";
                    } ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        <?php
        $url =  _API_ROOT . "/question/read-accepted-and-not-deleted.php";
        ?>
        setInterval(() => {
            fetch('<?php echo $url ?>')
                .then(
                    function(response) {
                        if (response.status !== 200) {
                            console.log('Lỗi, mã lỗi ' + response.status);
                            return;
                        }
                        // parse response data
                        response.json().then(data => {
                            var questions = data['res']['questions'];
                            for (var question of questions) {
                                $('#likes_of_' + question["id_question"]).text(question['likes']);
                                $('#answers_of_' + question["id_question"]).text(question['comment']);
                            }
                        })
                    }
                )
                .catch(err => {
                    console.log('Error :-S', err)
                });
        }, 100);

        $(".like_ques").on("click", function() {
            const td = $(this).closest('p').find('span');
            var i = td[0].innerHTML;
            var data = {
                "question_id": i,
                "owner_id": "<?php echo $_SESSION["user_id"] ?>",
                "jwt": "<?php echo $_SESSION["jwt"] ?>"
            };

            $.ajax({
                contentType: 'application/json; charset=utf-8',
                type: "POST",
                url: "<?php echo (_API_ROOT . 'likes/create_ques.php') ?>",
                dataType: "json",
                success: function(result, status, xhr) {

                    if (result.check == 1) {
                        var result = document.getElementById("like_ans_" + i);
                        result.style.color = "#db9b00";
                        var result1 = document.getElementById("likes_of_" + i);
                        result1.style.color = "#db9b00";
                    } else {
                        var result = document.getElementById("like_ans_" + i);
                        result.style.color = "black";
                        var result1 = document.getElementById("likes_of_" + i);
                        result1.style.color = "black";
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 401) {
                        $("#loadMe").modal("hide");
                        alert("Phiên đăng nhập của bạn đã hết. Xin vui lòng đăng nhập lại");
                        window.location = "<?php echo _WEB_ROOT . "/login/logout"; ?>";
                    } else {
                        $("#loadMe").modal("hide");
                        alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
                    }

                },
                data: JSON.stringify(data)
            });

        });



    }, );
</script>