<div class="modal fade" id="modalTambahEditITdaily" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditITdaily" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Job IT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahITdaily')) !!}
        <div class="row">
          <div class="form-group col-xs-12">
            {!! Form::label('slug','Slug',array('style'=>'display:none')) !!}
            {!! Form::text('slug','',array('style' => 'display:none')) !!}
          </div>
          <div class="form-group col-xs-12 col-md-6">
            <label for="id_unit">Nama Unit</label>
            <select name="unit" id="unit" required>
              <option value="" selected></option>
              @foreach($units as $unit)
                <option value="{{$unit->slug}}">{{$unit->nama_unit}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-xs-12 col-md-6">
            {!! Form::label('tgl_kejadian','Tanggal Kejadian') !!}
            {!! Form::date('tgl_kejadian','',array("class" => "form-control form-control-sm", "required" ))!!}
            <div class="invalid-feedback">
              Tanggal Kejadian Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12 col-md-6 timepicker">
            {!! Form::label('waktu_kejadian','Waktu Kejadian') !!}
            {!! Form::text('waktu_kejadian','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Waktu Kejadian", "required" ))!!}
            <div class="invalid-feedback">
              Waktu Kejadian Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12 col-md-6">
            {!! Form::label('nama_user_request','Nama Pegawai') !!}
            {!! Form::text('nama_user_request','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Pegawai yang Request", "required"))!!}
            <div class="invalid-feedback">
              Nama User Request Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12 col-md-6">
            {!! Form::label('problem','Keterangan / Masalah') !!}
            {!! Form::textarea('problem','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Keterangan / Masalah", "required", "rows"=>'2', 'style'=>'resize:none'))!!}
            <div class="invalid-feedback">
              Keterangan / Masalah Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12 col-md-6">
            {!! Form::label('solusi','Solusi') !!}
            {!! Form::textarea('solusi','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Solusi dari Masalah", "required", "rows"=>'2', 'style'=>'resize:none'))!!}
            <div class="invalid-feedback">
              Solusi Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12 col-md-12">
            {!! Form::label('it_solved_by', 'Di Kerjakan Oleh') !!}
            {!! Form::text('it_solved_by','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Pegawai yang Request", "required", "readonly"=>true))!!}
            <div class="mt-1 small btn-group btn-group-sm">
              <button type="button" id="kresnana" class="btn btn-muted">Kresnana</button>
              <button type="button" id="darma" class="btn btn-muted">Darma</button>
              <button type="button" id="bayu" class="btn btn-muted">Bayu</button>
              <button type="button" id="agus" class="btn btn-muted">Agus</button>
            </div>
          </div>

          <div class="form-check form-check-inline ml-4 pl-2 ">
              <input class="form-check-input" type="checkbox" id="status" name="status">
              <label for="status">Sudah Selesai</label>
          </div>
        </div>

          <div class="text-right">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Batal</button>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
