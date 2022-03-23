@extends('master.master')
@section('title','Data Unit')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Unit</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelUnit"></div>
    </div>

    <div class="card-footer">
      <button role="button" class="btn btn-primary" title="Tambah Data Unit" data-toggle="modal" data-target="#modalTambahEditUnit"><span class="fa fa-plus"></span> Data Unit</button>
    </div>
  </div>

  @include('unit.modalDeleteDataUnit')
  @include('unit.modalTambahEditUnit')
@endsection

@section('additionalJS')
<script type="text/javascript" src="{!! asset('js/needs_validation.js') !!}"></script>
<script type="text/javascript">
  function sweetTable(){
    $('#tabelUnit').DataTable({
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
      }
    });
  }

  function showTableUnit(){
    $.ajax({
      type:'GET',
      url:'getUnit',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-sm" id="tabelUnit" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-left customTableResponsive">No</th>\
              <th class="col-xs-4 text-left customTableResponsive">Nama Unit</th>\
              <th class="col-xs-5 text-left customTableResponsive">Deskripsi Unit</th>\
              <th class="col-xs-2 text-center customTableResponsive">Aksi</th>\
            </tr>\
          </thead>\
          <tbody>';
        var no = 0;
        var data2 ='';
          for(indeks in jsonData){
            data2 += '\
            <tr>\
              <td class="col-xs-1 text-left customTableResponsive">'+ ++no +'</td>\
              <td class="col-xs-4 text-left customTableResponsive">'+ jsonData[indeks].nama_unit +'</td> \
              <td class="col-xs-5 text-left customTableResponsive">';
                if(jsonData[indeks].deskripsi_unit == null){
                data2 += 'Tidak Ada Data Deskripsi';
                }else{
                data2 += jsonData[indeks].deskripsi_unit;
                }
            data2 += '\
              </td> \
              <td class="col-xs-2 text-right customTableResponsive">\
                <a role="button" class="btn btn-warning" title="Ubah Data Unit" data-toggle="modal" data-target="#modalTambahEditUnit" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].nama_unit+'&hobayu&'+jsonData[indeks].deskripsi_unit+'"><span class="far fa-edit"></span></a>\
                <a role="button" class="btn btn-danger" title="Hapus Data Unit" data-toggle="modal" data-target="#modalDeleteDataUnit" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].nama_unit+'&hobayu&'+jsonData[indeks].deskripsi_unit+'"><span class="far fa-trash-alt"></span></a>\
              </td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataTabelUnit').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelUnit").style.display = "none";
  });
  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelUnit").style.display = "";
  });

  $(document).ready(function(){
    showTableUnit();
    $('#modalDeleteDataUnit').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      recipient = recipient.split('&hobayu&')
      var modal = $(this)
      modal.find('.modal-body #namaUnit_delete_modal').html('<b>Nama Unit :</b><br/> '+recipient[1]+'<br/><br/>')
      modal.find('.modal-body #deskripsi_unit_delete_modal').html('<b>Deskripsi Unit :</b><br/> '+recipient[2])
      modal.find('.modal-footer a').attr('href',recipient[0])
    });

    $('#modalTambahEditUnit').on('show.bs.modal', function(event){
      $('#editTambahUnit').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      var modal = $(this)
      if(recipient != null){
        recipient = recipient.split('&hobayu&')
        modal.find('.modal-body #slug').val(recipient[0])
        modal.find('.modal-body #nama_unit').val(recipient[1])
        if(recipient[2] != "null"){
          modal.find('.modal-body #deskripsi_unit').val(recipient[2])
        }else{
          modal.find('.modal-body #deskripsi_unit').val('')
        }

      }else{
        modal.find('.modal-body #slug').val('')
        modal.find('.modal-body #nama_unit').val('')
        modal.find('.modal-body #deskripsi_unit').val('')
      }
    });

    $('#editTambahUnit').on('submit',function(e){
      e.preventDefault();
      var nama_unit = $('#nama_unit').val();
      var deskripsi_unit = $('#deskripsi_unit').val();
      var slug = $('#slug').val();
      var url_dest = '';
      if(nama_unit.trim() != ""){
        if(slug == ''){
          //tambah unit
          url_dest = 'unit/tambahUnit';
          $('#modalTambahEditUnit').modal('hide');
          $.ajax({
            type:'POST',
            url:url_dest,
            data:$(this).serializeArray(),
            success:function(data){
              var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                              data.msg +
                              '<button data-dismiss="alert" class="close" aria-label="Close">'+
                              '<span aria-hidden="true">&times;</span>'+
                              '</button>'+
                            '</div>';
              $("#statusMsg").html(alert);
              $('#nama_unit').val('');
              $('#deskripsi_unit').val('');
              $('#slug').val('');
              showTableUnit();
            }
          });
        }else{
          //edit unit
          url_dest = 'unit/'+slug+'/editUnit';
          $('#modalTambahEditUnit').modal('hide');
          $.ajax({
            type:'POST',
            url:url_dest,
            data:{"_token": "{{ csrf_token() }}", "nama_unit":nama_unit, "deskripsi_unit":deskripsi_unit},
            success:function(data){
              var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                              data.msg +
                              '<button data-dismiss="alert" class="close" aria-label="Close">'+
                              '<span aria-hidden="true">&times;</span>'+
                              '</button>'+
                            '</div>';
              $("#statusMsg").html(alert);
              $('#nama_unit').val('');
              $('#deskripsi_unit').val('');
              $('#slug').val('');
              showTableUnit();
            }
          });
        }
      }
    });

    $('#hapusDataUnit').on('click',function(e){
      e.preventDefault();
      var slug = $(this).attr('href');
      $('#modalDeleteDataUnit').modal('hide');
      $.ajax({
        type:'GET',
        url: 'unit/'+slug+'/deleteUnit',
        success:function(data){
          var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                          data.msg +
                          '<button data-dismiss="alert" class="close" aria-label="Close">'+
                          '<span aria-hidden="true">&times;</span>'+
                          '</button>'+
                        '</div>';
          $("#statusMsg").html(alert);
          showTableUnit();
        }
      });
    })
  });
</script>
@endsection
