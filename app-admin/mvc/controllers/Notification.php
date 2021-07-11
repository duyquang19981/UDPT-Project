<?php
class Notification extends Controller
{
  public $AdminModel;

  public function __construct()
  {
    $this->AdminModel = $this->model("AdminModel");
  }

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Home');
  }

  public function TurnOn()
  {
    if (isset($_POST["submitToggleFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $requestData = [
        "id_admin" =>  $id_admin
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/admin/turn-on-notification.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        Session::set('notification_yes', 1);
      }
      header('Location:' . _WEB_ROOT . '/Home');
    } else {
      header('Location:' . _WEB_ROOT . '/Home');
    }
  }

  public function TurnOff()
  {
    if (isset($_POST["submitToggleFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $requestData = [
        "id_admin" =>  $id_admin
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/admin/turn-off-notification.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        Session::set('notification_yes', 0);
      }
      //Show result
      header('Location:' . _WEB_ROOT . '/Home');
    } else {
      header('Location:' . _WEB_ROOT . '/Home');
    }
  }

  public function Read()
  {
    // NOTE: Đặt câu hỏi, trả lời, thêm thông báo cho admin
    // NOTE: nếu thông báo cho đăng câu hỏi thì id_answer = null,
    // nếu thông báo cho câu trả lời thì id_question = null
    // Nội dung câu hỏi ( trường content trong notification): "Câu hỏi từ người dùng 'id_user': day la noi dung cau hoi."
    // Nội dung câu hỏi ( trường content trong notification): "Câu trả lời từ người dùng 'id_user': day la noi dung cau tra loi."

    // Nếu admin có notification_yes = 0 thì không thêm thông báo, notification_yes = 1 thì thêm,
    // thêm trong notification_admin
    
    $admin_id = Session::get("admin-id");
    $requestData = [
      "admin_id" =>  $admin_id
    ];
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/notification/read-my-noti.php";
    $responseData =  $callapi->callAPI("POST", $url,  $requestData);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $notifications = [];
      foreach ($res["notifications"] as $notiInArr) {
        //check if the question or the answer is accepted
        $notification = $notiInArr['notification'];
        $id_check = 0;
        $table_check = '';
        if (!empty($notification["id_question"])) {
          $id_check =  $notification["id_question"];
          $table_check = "question";
        } else {
          $id_check =  $notification["id_answer"];
          $table_check = "answer";
        }
        $requestData = [
          "id_check" =>  $id_check,
        ];
        $requestData = json_encode($requestData);
        $url =  _API_ROOT . "/" . $table_check . "/readById.php";
        $responseData =  $callapi->callAPI("POST", $url,  $requestData);
        $responseData = $responseData["data"];
        $resCheck = $responseData["res"];
        $notification['isAccepted'] = "false";
        if ($resCheck["result"] != "false") {
          if ($resCheck[$table_check . "s"][0]["mod_id"] != null) {
            $notification['isAccepted'] = "true";
          }
        }
        array_push($notifications, $notification);
      }
      $data =  [
        "View" => "notification",
        "Notifications" => $notifications,
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function Accept()
  {
    if (isset($_POST["submitAcceptNotification"])) {
      $id_noti = $_POST["id_noti"];
      $mod_id = $_POST["mod_id"];
      $today = date("Y-m-d");
      $requestData = [
        "id_check" =>  trim($id_noti),
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/notification/readById.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        $notification = $res["notifications"][0];
        if (!empty($notification["id_question"])) {
          $requestData = [
            "id_question" =>  trim($notification["id_question"]),
            "mod_id" => trim($mod_id),
            "accept_day" => $today
          ];
          $requestData = json_encode($requestData);
          $url =  _API_ROOT . "/question/accept.php";
          $responseData =  $callapi->callAPI("POST", $url, $requestData);
          $responseData = $responseData["data"];
          $res = $responseData["res"];
          if ($res["result"] == "false") {
            echo "alert('Khong thanh cong')";
          }
        } else if (!empty($notification["id_answer"])) {
          $requestData = [
            "id_answer" =>  trim($notification["id_answer"]),
            "mod_id" => trim($mod_id),
            "accept_day" => $today
          ];
          $requestData = json_encode($requestData);
          $url =  _API_ROOT . "/answer/accept.php";
          $responseData =  $callapi->callAPI("POST", $url, $requestData);
          $responseData = $responseData["data"];
          $res = $responseData["res"];
          if ($res["result"] == "false") {
            echo "alert('Khong thanh cong')";
          }
        }
      }
    }
    header('Location:' . _WEB_ROOT . '/Notification/Read/' . $mod_id);
  }
}
