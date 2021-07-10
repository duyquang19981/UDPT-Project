$(document).ready(function () {
  var searchkey = getParameterByName('searchkey') || null;
  var page = getParameterByName('page') || 1;
  console.log('searchkey :>> ', searchkey);
  console.log('page :>> ', page);
  // Activate tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Select/Deselect checkboxes
  var checkbox = $('table tbody input[type="checkbox"]');
  $('#selectAll').click(function () {
    if (this.checked) {
      checkbox.each(function () {
        this.checked = true;
      });
    } else {
      checkbox.each(function () {
        this.checked = false;
      });
    }
  });
  checkbox.click(function () {
    if (!this.checked) {
      $('#selectAll').prop('checked', false);
    }
  });

  $('.editButton').click(function () {
    console.log('accpet thongbao');
    const td = $(this).closest('tr').find('td');
    const _id = td[0].innerHTML;
    const edit_input_id = $('#edit_input_id');
    edit_input_id[0].value = _id;
  });

  $('.deleteButton').click(function () {
    console.log('delete giang vien');

    const td = $(this).closest('tr').find('td');
    const _id = td[0].innerHTML;
    const delete_input_id = $('#delete_input_id');
    delete_input_id[0].value = _id;
    let SoKhoaHoc = -1;
    var xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'GiangVien/getnumberofcourse?_id=' + _id);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    xhttp.onreadystatechange = async function () {
      if (this.readyState == 4 && this.status == 200) {
        //alert(this.responseText);
        var resText = this.responseText;
        SoKhoaHoc = JSON.parse(resText).numberofcourse;
        const noti = $('.noti');
        if (SoKhoaHoc > 0) {
          noti[0].innerHTML = `This GiangVien has some available courses. GiangVien can't be deleted!`;
          $('#deleteButton').attr('disabled', 'disabled');
          $('.text-warning').css('display', 'none');
        } else if (SoKhoaHoc == -1) {
          noti[0].innerHTML = `Can't get data from server. Try again!`;
          $('#deleteButton').attr('disabled', 'disabled');
          $('.text-warning').css('display', 'none');
        } else {
          noti[0].innerHTML = `Are you sure you want to delete these Records?`;
        }
      }
    };
  });

  // xem danh sach khoa hoc
  $('.detail').click(function () {
    console.log('xem chi tiet khoa hoc');
    const td = $(this).closest('tr').find('td');
    const _id = td[0].innerHTML;
    var xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'TheLoai/getcoursesincate?_id=' + _id);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //alert(this.responseText);
        var resText = this.responseText;
        console.log('resText :>> ', resText);
      }
    };
  });
});
