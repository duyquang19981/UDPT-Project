<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="<?php echo _PUBLIC ?>/js/admin-crud/admin-crud-cauhoi.js"></script>

<div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Bảng <b>Câu hỏi</b></h2>
          </div>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Mã</th>
            <th style="width:1px;">User</th>
            <th>Danh mục</th>
            <th>Admin duyệt</th>
            <th>Nội dung</th>
            <th>Số like</th>
            <th>Ngày tạo</th>
            <th>Ngày duyệt</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($data["Questions"]) && count($data["Questions"]) > 0) {
            foreach ($data["Questions"] as $question) { ?>
              <tr>
                <td><?php echo $question["id_question"]; ?></td>
                <td><?php echo $question["owner_id"]; ?></td>
                <td><?php echo $question["category_id"]; ?></td>
                <td><?php echo $question["mod_id"]; ?></td>
                <td>
                  <button onclick="(
                      function(){alert('<?php echo trim($question['description']); ?>'); 
                      return false;})(); return false; " style="  
                      white-space: nowrap; 
                      width: 420px; 
                      display: block;
                      overflow: hidden;
                      text-overflow: ellipsis;
                      text-align:left;
                      border:none;
                    "><?php echo trim($question["description"]); ?></button>
                </td>
                <td><?php echo $question["likes"]; ?></td>
                <td><?php echo $question["created"]; ?></td>
                <td><?php echo $question["accept_day"]; ?></td>
                <td> <?php echo $question["status"]; ?></td>
                <td>
                  <a href="#editRecord" class="editButton edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Approve">&#xE254;</i></a>
                  <a href="#deleteRecord" class="deleteButton delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
  </div>
</div>
<!-- add Modal HTML -->

<div id="editRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="edit_form" method="POST" action="<?php echo _WEB_ROOT ?>/Question/Accept">
        <div class="modal-header">
          <h4 class="modal-title">Duyệt câu hỏi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Mã</label>
            <input id="edit_input_id" readonly name="id_question" type="text">
            <input id="edit_input_id_mod" style="display:none" value="<?php echo Session::get("admin-id"); ?>" name="mod_id" type="text">

          </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input id="saveButton" name="submitAcceptQuestion" type="submit" class="btn btn-info" value="Save">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form name="deleteForm" method="POST" action="<?php echo _WEB_ROOT ?>/Question/Delete">
        <div class="modal-header">
          <h4 class="modal-title">Delete Record</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p class="noti">Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input id="delete_input_id" name="id_question" type="text" style="display: none;">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input id="deleteButton" name="submitDeleteQuestion" type="submit" class="btn btn-danger" value="Delete">
        </div>
      </form>
    </div>
  </div>
</div>