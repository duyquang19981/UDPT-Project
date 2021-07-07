<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="<?php echo _PUBLIC ?>/js/admin-crud/admin-crud-danhmuc.js"></script>

<div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Bảng <b>Danh mục câu hỏi</b></h2>
          </div>
          <div class="col-sm-6">
            <a href="#addRecord" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Record</span></a>

          </div>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Mã</th>
            <th style="width:1px;">Tên danh mục</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Admin tạo</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($data["Categories"]) && count($data["Categories"]) > 0) {
            foreach ($data["Categories"] as $category) { ?>
              <tr>
                <td><?php echo $category["category_id"]; ?></td>
                <td><?php echo trim($category["name"]); ?></td>
                <td><?php echo $category["status"]; ?></td>
                <td><?php echo $category["created"]; ?></td>
                <td> <?php echo $category["mod_id"]; ?></td>
                <td>
                  <a href="#editRecord" class="editButton edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
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
<div id="addRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addForm2" method="POST" action="<?php echo _WEB_ROOT ?>/Category/Create">
        <div class="modal-header">
          <h4 class="modal-title">Thêm danh mục</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Tên: </label>
            <input name="id_admin" value="<?php echo Session::get("admin-id") ?>" type="text" class="form-control" hidden=true>
            <input name="cate_name" type="text" class="form-control" required maxlength="200">
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input name="submitAddCategoryFormBtn" type="submit" class="btn btn-success" value="Add">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Modal HTML -->
<div id="editRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="edit_form" method="POST" action="<?php echo _WEB_ROOT ?>/Category/Update">
        <div class="modal-header">
          <h4 class="modal-title">Edit Record</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Tên</label>
            <input id="edit_input_id" style="display:none" name="cate_id" type="text">
            <input id="edit_input_ten" name="cate_name" type="text" class="form-control" required maxlength="30">

          </div>


        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input id="saveButton" name="submitUpdateCate" type="submit" class="btn btn-info" value="Save">
        </div>
      </form> 
    </div>
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form name="deleteForm" method="POST" action="<?php echo _WEB_ROOT ?>/Category/Delete">
        <div class="modal-header">
          <h4 class="modal-title">Delete Record</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p class="noti">Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input id="delete_input_id" name="cate_id" type="text" style="display: none;">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input id="deleteButton" name="submitDeleteCate" type="submit" class="btn btn-danger" value="Delete">
        </div>
      </form>
    </div>
  </div>
</div>