@extends('master.master')
@section('title','Data Job IT')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Job IT</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive small" id="dataTabelITdaily"></div>
    </div>

    <div class="card-footer">
      <button role="button" class="btn btn-primary" title="Tambah Data Job IT" data-toggle="modal" data-target="#modalTambahEditITdaily"><span class="fa fa-plus"></span> Data Job IT</button>
    </div>
  </div>

  @include('itdaily.modalDeleteDataITdaily')
  @include('itdaily.modalTambahEditITdaily')
@endsection

@section('additionalJS')
<script type="text/javascript" src="{!! asset('js/needs_validation.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/formData.js') !!}"></script>
<script type="text/javascript">
  function sweetTable(){
    var dataTable = $('#tabelITdaily').DataTable({
      "language": {
        "zeroRecords": "Tidak ada Data",
        "info": "Tampil Data _START_ sampai _END_ dari _TOTAL_ Jumlah Data",
        "infoEmpty": "Tampil 0 sampai 0 dari 0 Jumlah Data",
        "lengthMenu": "Tampilkan _MENU_ Jumlah Data",
        "search": "Cari ",
        "paginate": {
          "first":      "<<",
          "last":       ">>",
          "next":       ">",
          "previous":   "<"
        },
        "infoFiltered":   "(diambil dari _MAX_ jumlah seluruh data)",
      },
      'dom': '<"toolbar"><"pencarian"fr>tlrip<"kumpulanButton">B',
    });
    var toolbarTambahan = '';
    toolbarTambahan += '<div class="form-inline">\
    <label for="searchKonfirmasi">Tampilkan</label>\
    <select name="searchKonfirmasi" id="searchKonfirmasi" class="form-control form-control-sm mx-1">\
      <option value="" selected>Semua Status</option>\
      <option value="1">Done </option>\
      <option value="0">Progress </option>\
    </select>';

    toolbarTambahan += '\
    <input class="form-control form-control-sm mx-1" type="date" name="searchRangeCheckInCheckOut1" id="searchRangeCheckInCheckOut1" value=""/>\
    <label for="searchRangeCheckInCheckOut2">Sampai </label>\
    <input class="form-control form-control-sm mx-1" type="date" name="searchRangeCheckInCheckOut2" id="searchRangeCheckInCheckOut2" value=""/>\
    </div>';

    var buttonConvert = '';
        buttonConvert += '\
        <button class="btn btn-success" id="pdf"><span class="fa fa-download"></span> PDF</button>';
        
    $('div.toolbar').html(toolbarTambahan)
    $('div.toolbar').addClass('float-left')
    $('div.kumpulanButton').html(buttonConvert)
    $('div.kumpulanButton').addClass('float-left')
    $('div.toolbar #searchKonfirmasi').on('change', function(){
      dataTable.columns(10).search($(this).val()).draw();
    });

    $('div.toolbar #searchRangeCheckInCheckOut1').on('change', function(){
      dataTable.draw();
    });
    $('div.toolbar #searchRangeCheckInCheckOut2').on('change', function(){
      dataTable.draw();
    });

    $.fn.dataTableExt.afnFiltering.push(
      function( oSettings, aData, iDataIndex ) {
        var check_in = $('#searchRangeCheckInCheckOut1').val();
        var check_out = $('#searchRangeCheckInCheckOut2').val();
        var kolomCheckIn = aData[11];
        if(check_in == undefined){
          check_in = '';
        }
        if(check_out == undefined){
          check_out = '';
        }
        if(check_in == '' && check_out == ''){
          return true;
        }
        if(check_in == ''){
          if(check_out >= kolomCheckIn){
            return true;
          }
        }
        if(check_out == ''){
          if(check_in <= kolomCheckIn){
            return true;
          }
        }
        if(check_in <= kolomCheckIn  && check_out >= kolomCheckIn){
          return true;
        }
        return false;
      }
    )

    $('div.kumpulanButton #excel').on('click',function(){
      var urlGoTo = $('div.toolbar #searchKonfirmasi').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val();
      window.location = 'itdaily/exportToExcel/'+ urlGoTo
    });

    $('div.kumpulanButton #pdf').on('click',function(){
      var urlGoTo = $('div.toolbar #searchKonfirmasi').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val();
      window.location = 'itdaily/exportToPdf/'+ urlGoTo
    });
  }

  function editData(objData){
    let strObjData = objData.replace(/&hobayu&/g,'"');
    strObjData = strObjData.replace(/\s+/g, ' ')
    // alert(strObjData)
    // alert(strObjData);
    // console.log(strObjData);
    // alert('hello')
    let objDataEdit = JSON.parse(strObjData);
    // alert(objDataEdit.problem)
    setDataForm(document.forms['editTambahITdaily'], objDataEdit);
  }

  function showTableITdaily(){
    $.ajax({
      type:'GET',
      url:'getITdaily',
      success:function(data){
        var dataTambahan = '';
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-bordered table-sm" id="tabelITdaily" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive">No</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tanggal Kejadian</th>\
              <th class="col-xs-1 text-center customTableResponsive">Waktu Kejadian</th>\
              <th class="col-xs-1 text-center customTableResponsive">Unit Request</th>\
              <th class="col-xs-1 text-center customTableResponsive">User Request</th>\
              <th class="col-xs-2 text-center customTableResponsive">Problem</th>\
              <th class="col-xs-2 text-center customTableResponsive">Solusi</th>\
              <th class="col-xs-1 text-center customTableResponsive">Dikerjakan</th>\
              <th class="col-xs-1 text-center customTableResponsive">Status</th>\
              <th class="col-xs-1 text-center customTableResponsive">Aksi</th>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Status</th>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Tanggal</th>\
            </tr>\
          </thead>\
          <tbody>';
        var no = 0;
        var data2 ='';
          for(indeks in jsonData){
            dataTambahan = ""+'&hobayu&'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks]['unit'].slug+'&hobayu&'+jsonData[indeks].tgl_kejadian+'&hobayu&'+jsonData[indeks].waktu_kejadian+'&hobayu&'+jsonData[indeks].nama_user_request+'&hobayu&'+cekQuoteString(jsonData[indeks].problem)+'&hobayu&'+cekQuoteString(jsonData[indeks].solusi)+'&hobayu&'+jsonData[indeks].it_solved_by+'&hobayu&'+''+'&hobayu&'+''+'&hobayu&'+''+'&hobayu&'+''+'&hobayu&'+jsonData[indeks].status;
            data2 += '\
            <tr'+(jsonData[indeks].status=="1"?"":" class='bg-secondary text-light'")+'>\
              <td class="col-xs-1 text-left customTableResponsive">'+ ++no +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ tanggal(jsonData[indeks].tgl_kejadian) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].waktu_kejadian +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks]['unit'].nama_unit +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].nama_user_request +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ jsonData[indeks].problem +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ jsonData[indeks].solusi +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].it_solved_by +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ (jsonData[indeks].status?"Done":"Progress") +'</td> \
              <td class="col-xs-2 text-right customTableResponsive">\
                <a role="button" class="btn btn-warning btn-sm" title="Ubah Data Job IT" data-toggle="modal" data-target="#modalTambahEditITdaily" data-tambahan="'+dataTambahan+'" onclick="editData(\''+cekQuoteString1(JSON.stringify(jsonData[indeks]))+'\')"><span class="far fa-edit"></span></a>\
                <a role="button" class="btn btn-danger btn-sm" title="Hapus Data Job IT" data-toggle="modal" data-target="#modalDeleteDataITdaily" data-tambahan="'+dataTambahan+'"><span class="far fa-trash-alt"></span></a>\
              </td>\
              <td class="col-xs-1 text-center customTableResponsive d-none">'+ jsonData[indeks].status +'</td> \
              <td class="col-xs-1 text-center customTableResponsive d-none">'+ jsonData[indeks].tgl_kejadian +'</td> \
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataTabelITdaily').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelITdaily").style.display = "none";
  });

  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelITdaily").style.display = "";
  });

  // function getUnit(){
  //   var dataUnit = '';
  //   $.ajax({
  //     type:'GET',
  //     url:'getUnit',
  //     success:function(data){
  //       var jsonData = data.msg;
  //       dataUnit += '\
  //       <label for="id_unit">Nama Unit</label>\
  //       // <select class="form-control form-control-sm" name="unit" id="unit" required>\
  //         <option value="" selected></option>';
  //         for(indeks in jsonData){
  //           dataUnit += '<option value="'+ jsonData[indeks].slug +'">'+ jsonData[indeks].nama_unit +'</option>';
  //         }
  //       dataUnit += '</select>\
  //       <div class="invalid-feedback">\
  //         Nama Unit Tidak Boleh Kosong\
  //       </div>';
  //       $('#modalTambahEditITdaily #dataUnit').html(dataUnit);
  //       $('#dataUnit #unit').select2({
  //         width : "100%",
  //         placeholder : "Pilih Unit"
  //       });
  //     }
  //   });
  // }

  $(document).ready(function(){
    showTableITdaily();
    $.fn.select2.defaults.set( "theme", "bootstrap4" );
    $('#modalTambahEditITdaily #unit').select2({
      width : "100%",
      placeholder : "Pilih Unit"
    });

    $('#editTambahITdaily #waktu_kejadian').timepicker({
      minuteStep: 1,
      showSeconds: true,
      showMeridian: false,
      defaultTime: 'current',
    });

    $('#editTambahITdaily #kresnana, #editTambahITdaily #darma, #editTambahITdaily #bayu, #editTambahITdaily #agus ').on('click',function(e){
      e.preventDefault();
      var valueForm = $('#editTambahITdaily #it_solved_by').val();
      if(valueForm == undefined){
        alert($(this).text());
        valueForm = " "+$(this).text() + ",";
        $('#editTambahITdaily #it_solved_by').val(valueForm);
      }else{
        if(valueForm.includes($(this).text())){
          valueForm = valueForm.replace($(this).text()+',','')
          $('#editTambahITdaily #it_solved_by').val(valueForm);
        }else{
          valueForm = valueForm + " "+$(this).text() + ",";
          $('#editTambahITdaily #it_solved_by').val(valueForm);
        }
      }
    });

    $('#modalDeleteDataITdaily').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      recipient = recipient.split('&hobayu&')
      var modal = $(this)
      // dataTambahan = jsonData[indeks].slug0+'&hobayu&'+jsonData[indeks]['unit'].slug1+'&hobayu&'+jsonData[indeks].nama_user_request2+'&hobayu&'+jsonData[indeks].problem3+'&hobayu&'+jsonData[indeks].solusi4+'&hobayu&'+jsonData[indeks].it_solved_by5+'&hobayu&'+jsonData[indeks].status6;
      modal.find('.modal-body #namaUser_delete_modal').html('<b>Nama User yang Request :</b><br/> '+recipient[5]+'<br/>')
      modal.find('.modal-body #masalah_delete_modal').html('<b>Keterangan / Masalah :</b><br/> '+recipient[6])
      modal.find('.modal-body #solusi_delete_modal').html('<b>Solusi :</b><br/> '+recipient[7])
      modal.find('.modal-body #dikerjakan_delete_modal').html('<b>Di Kerjakan Oleh :</b><br/> '+recipient[8])
      modal.find('.modal-body #status_delete_modal').html('<b>Status Pekerjaan :</b><br/> '+ (recipient[13]=="1"?"Done":"Progress"))
      modal.find('.modal-footer a').attr('href',recipient[1])
    });

    $('#modalTambahEditITdaily').on('show.bs.modal', function(event){
      $('#editTambahITdaily').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
      // var button = $(event.relatedTarget)
      // var recipient = button.data('tambahan')
      // var modal = $(this)
      // if(recipient != null){
      //   recipient = recipient.split('&hobayu&')
      //   setDataForm(document.forms['editTambahITdaily'], recipient);
      // }else{
      //   clearDataForm(document.forms['editTambahITdaily']);
      // }
    });

    $('#editTambahITdaily').on('submit',function(e){
      e.preventDefault();
      var slug = $('#editTambahITdaily #slug').val()
      if(cekValidasi(this)){
        if(slug == '' ){
          $('#modalTambahEditITdaily').modal('hide');
          sendToServer(this, 'POST', 'itdaily/tambahITdaily', false, 'statusMsg', showTableITdaily);
        }else{
          $('#modalTambahEditITdaily').modal('hide');
          sendToServer(this, 'POST', 'itdaily/'+slug+'/editITdaily', false, 'statusMsg', showTableITdaily);
        }
      }
    });

    $('#hapusDataITdaily').on('click',function(e){
      e.preventDefault();
      var slug = $(this).attr('href');
      $('#modalDeleteDataITdaily').modal('hide');
      sendToServer('', 'GET', 'itdaily/'+slug+'/deleteITdaily', false, 'statusMsg', showTableITdaily);
    })
  });
</script>
@endsection
