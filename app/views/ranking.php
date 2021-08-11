<style>
  .rank {
    color: #fff;
    text-align: center;
    font-weight: bold;
    padding: 14px 0;
    font-size: 24px;
    display: inline-block;
    height: inherit;
    width: 50px;
  }

  .username {
    font-size: 20px;
    display: inline-block;
    position: absolute;
    margin-left: 25px;
  }

  .answer {
    font-size: 18px;
    display: inline-block;
    position: absolute;
    margin-left: 25px;
    margin-top: 28px;
  }
</style>

<div class="card" style="width: 100%;height: auto;overflow: hidden;padding: 1%;background-color: #fff;border-radius: 5px;box-shadow: 1% ">

  <div class="card-body" style="padding:1%">
    <div class="row" style="text-align: center; font-size: 30px">
      <div class="col-sm-1"></div>
      <div class="col-sm-10 ">
        <b style="display:block">BẢNG XẾP HẠNG THÁNG
          <b style="color: rgb(247, 182, 6);"> <?php echo date('m'); ?></b>
        </b>
        <div class="" style="margin: 45px auto; width:50%; padding-left:11%">
          <?php
          if (isset($data["Users"])) {
            $users = $data["Users"];
            $max = 10 < count($users) ? 10 : count($users);
            $color = '#8dc354';
            for ($i = 0; $i < $max; $i++) {
              switch ($i) {
                case 0:
                  $color = '#f97d65';
                  break;
                case 1:
                  $color = '#ffcd46';
                  break;
                case 2:
                  $color = '#3e4d84';
                  break;
                default:
                  $color = '#8dc354';
                  break;
              }
          ?>
              <div style="height: 50px; margin:15px 0; text-align:left;" class="row ">
                <span style=" background: <?php echo $color; ?>;" class="rank">
                  <?php echo $i + 1; ?>
                </span>
                <b class="username">
                  <?php echo $users[$i]["name"]; ?>
                </b>
                <span class="answer">
                  Trả lời:
                  <b style="color: rgb(247, 182, 6);"> <?php echo $users[$i]["answer"]; ?></b>
                </span>

              </div>

          <?php  }
          }

          ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3"></div>

    </div>
  </div>

</div>