<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="<?php echo _PUBLIC ?>/js/admin-crud/admin-crud-user-account.js"></script>

<div class="container-xl">
<div style="width: 50%;top: 50%;text-align: center;" >
   <div style="width: 100%;display: flex;">
      <input type="text" id="search"  placeholder="What are you looking for?" style="width: 100%;border: 3px solid #435d7d;border-right: none;padding: 5px;height: 40px;border-radius: 5px 0 0 5px;outline: none;">
      <button id="searchbuton"  style="width: 40px;height: 36px;border: 1px solid #435d7d;background: #435d7d;text-align: center;color: #fff;border-radius: 0 5px 5px 0;height: 40px;cursor: pointer;font-size: 20px;">
        <i class="fa fa-search"></i>
     </button>
   </div>
</div>
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Bảng <b>Danh sách User</b></h2>
          </div>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th style="text-align: center;">Mã user</th>
            <th >Tên user</th>
            <th>Email</th>
            <th>SDT</th>
            <th style="text-align: center;">Trạng thái</th>
            <th>Ngày tạo</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($data["User"]) && count($data["User"]) > 0) {
            foreach ($data["User"] as $category) { ?>
              <tr>
                <td style="text-align: center;"><?php echo $category["id_user"]; ?></td>
                <td><?php echo $category["name"]; ?></td>
                <td><?php echo $category["email"]; ?></td>
                <td><?php echo $category["phone"]; ?></td>
                <td style="text-align: center;"> <?php echo $category["status"]; ?></td>
                <td> <?php echo $category["created"]; ?></td>
                <td>
                  <a href="#statusRecord" class="changestatus delete" data-toggle="modal" ><i class="material-icons" data-toggle="tooltip" title="<?php if($category["status"] == 1){ echo "Disable User";} else { echo "Enable User";}?>"><?php if($category["status"] == 1){ echo "&#xe5cd";} else { echo "&#xe5ca;" ;}?></i></a>
                </td>
              </tr> 
            <?php
            }
          } else { ?>
            <td>Không có dữ liệu</td>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <nav aria-label="..." style="margin-top:1%">
      <ul class="pagination pagination-sm">
      <?php
      if (isset($data["User"]) && count($data["User"]) > 0) 
      {
        if (isset($data["paging"]) && count($data["paging"]["pages"]) > 0 && isset($data["keyword"])) {
          foreach ($data["paging"]["pages"] as $Page) { ?>
            <li class="page-item <?php if($Page["current_page"] == "yes"){ echo "disabled";}?>">
              <a class="page-link" href="/udpt-project/app-admin/user_account/Search/<?php echo $data["keyword"]."/"?><?php echo $Page["page"]."\"" ?>" tabindex="-1" style="background-color:powderblue;" ><?php echo $Page["page"] ?></a>
            </li>
            <?php
            }
        }
        else
        {
          foreach ($data["paging"]["pages"] as $Page) { ?>
            <li class="page-item <?php if($Page["current_page"] == "yes"){ echo "disabled";}?>">
              <a class="page-link" href="/udpt-project/app-admin/user_account/Read/<?php echo $Page["page"]."\"" ?>" tabindex="-1" style="background-color:powderblue;" ><?php echo $Page["page"] ?></a>
            </li>
            <?php
            }
        }  
      }?>
      </ul>
    </nav>
   
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="statusRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form name="statusForm" method="POST" action="<?php echo _WEB_ROOT ?>/user_account/updateStatus">
        <div class="modal-header">
          <h4 class="modal-title">Delete Record</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p class="noti">Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input id="user_input_id" name="user_input_id" type="text" style="display: none;">
          <input id="status" name="status" type="text" style="display: none;">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input type="submit" class="btn btn-danger" name="changestatus">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body row" >
        <div id="loader" ></div>
        <div style="margin-left:5%; font-size: 30px;">Loading..........</div> 
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $("#searchbuton").on("click", function() {
      var search = document.getElementById('search').value;
      if(search == "" || search == null)
      {
        window.location="<?php echo _WEB_ROOT."/user_account/Read/1"?>" ;
      }
      else
      {
        var link = search + "/1";
        window.location="<?php echo _WEB_ROOT."/user_account/Search/"?>" + link ;
      }
      
  });
});
</script>


