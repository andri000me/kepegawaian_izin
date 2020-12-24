<!-- Author : Fitra Arrafiq -->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		table = $('#myData').DataTable({
			"processing": true,
			"serverSide": true,
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"responsive": true,
			"dataType": 'JSON',
			// "dom": 'Bfrtip',
			// "buttons": [
			//     'copy', 'csv', 'excel', 'pdf', 'print'
			// ],
			"ajax": {
				"url": "<?php echo site_url('pengajuan_izin/izin/getAllData') ?>",
				"type": "POST",
				"data": {
					'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
				}
			},
			"order": [
				[0, "desc"]
			],
			"columnDefs": [{
				"targets": [0],
				"className": "center"
			}]
		});
	});

	var save_method;

	function updateAllTable() {
		table.ajax.reload();
	}

	function tambah() {
		save_method = 'add';
		$('#form_inputan')[0].reset();
		$('.form-group').removeClass('has-error')
			.removeClass('has-success')
			.find('#text-error').remove();
		$('#modalAdd').modal('show');
		$('.reset').show();
	}

	function ubah(id) {
		save_method = 'update';
		$('#form_inputan')[0].reset();
		$('#modalAdd').modal('show');
		$('.form-group').removeClass('has-error')
			.removeClass('has-success')
			.find('#text-error').remove();
		$.ajax({
			url: "<?php echo site_url('pengajuan_izin/izin/get_by_id/'); ?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(resp) {
				data = resp.data
				$('[name="id_izin"]').val(data.id_izin);
				$('[name="nama"]').val(data.nama);
				$('[name="id_pegawai"]').val(data.id_pegawai);
				$('[name="tgl_mulai"]').val(data.tgl_mulai);
				$('[name="tgl_akhir"]').val(data.tgl_akhir);
				$('[name="jadwal_off"]').val(data.jadwal_off);
				$('[name="id_jenis_izin"]').val(data.id_jenis_izin);
				$('.reset').hide();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error Get Data From Ajax');
			}
		});

	}

	function verifikasi(id) {
		save_method = 'update';
		$('#form_inputanKA')[0].reset();
		$('#modalVerifikasi').modal('show');
		$('.form-group').removeClass('has-error')
			.removeClass('has-success')
			.find('#text-error').remove();
		$.ajax({
			url: "<?php echo site_url('pengajuan_izin/izin/get_by_id/'); ?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(resp) {
				data = resp.data
				$('[name="id_izin"]').val(data.id_izin);
				$('[name="lama_izin"]').val(data.izin_lama);
				$('[name="tgl_mulai"]').val(data.tgl_mulai);
				$('[name="tgl_akhir"]').val(data.tgl_akhir);
				$('[name="acc_kaunit"]').val(data.acc_kaunit);
				$('[name="ket_kaunit"]').val(data.ket_kaunit);
				$('[name="acc_kabid"]').val(data.acc_kabid);
				$('[name="ket_kabid"]').val(data.ket_kabid);
				$('[name="acc_kabid_sdm"]').val(data.acc_kabid_sdm);
				$('[name="ket_sdm"]').val(data.ket_sdm);
				$('.reset').hide();
				if (data.jenis_izin != 'Lain-lain') {
					$('.tgl_mulai').hide();
					$('#tgl_mulai_label').hide();
					$('.tgl_akhir').hide();
					$('#tgl_akhir_label').hide();
				} else {
					$('.tgl_mulai').show();
					$('#tgl_mulai_label').show();
					$('.tgl_akhir').show();
					$('#tgl_akhir_label').show();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error Get Data From Ajax');
			}
		});

	}

	function uploadGbr(id) {
		save_method = 'update';
		$('#form_inputan1')[0].reset();
		$('#modalUpload').modal('show');
		$('.form-group').removeClass('has-error')
			.removeClass('has-success')
			.find('#text-error').remove();
		$.ajax({
			url: "<?php echo site_url('pengajuan_izin/izin/getById/'); ?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(resp) {
				data = resp.data
				$('[name="id_izin"]').val(data.id_izin);
				$('[name="nama"]').val(data.nama);
				$('.reset').hide();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error Get Data From Ajax');
			}
		});

	}

	function hapus(id) {
		swal({
				title: "Apakah Yakin Akan Dihapus?",
				type: "warning",
				showCancelButton: true,
				showLoaderOnConfirm: true,
				confirmButtonText: "Ya",
				closeOnConfirm: false
			},
			function() {
				$.ajax({
					url: "<?php echo site_url('pengajuan_izin/izin/delete'); ?>/" + id,
					type: "POST",
					dataType: "JSON",
					data: {
						'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
					},
					success: function(resp) {
						data = resp.result;
						updateAllTable();
						return swal({
							html: true,
							timer: 1300,
							showConfirmButton: false,
							title: data['msg'],
							type: data['status']
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error Deleting Data');
					}
				});
			});
	}

	function save() {
		var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
		var csrf_hash = ''
		var url;
		if (save_method == 'add') {
			url = '<?php echo base_url() ?>Pengajuan_izin/izin/addData';
		} else {
			url = '<?php echo base_url() ?>pengajuan_izin/izin/update';
		}
		swal({
				title: "Apakah anda sudah yakin ?",
				type: "warning",
				showCancelButton: true,
				showLoaderOnConfirm: true,
				cancelButtonText: "Kembali",
				confirmButtonText: "Ya",
				closeOnConfirm: false
			},
			function() {
				$.ajax({
					url: url,
					method: 'POST',
					data: $('#form_inputan').serialize(),
					dataType: "JSON",
					success: function(resp) {
						data = resp.result
						csrf_hash = resp.csrf['token'];
						$('#form_inputan input[name=' + token_name + ']').val(csrf_hash);
						if (data['status'] == 'success') {
							updateAllTable();
							$('.form-group').removeClass('has-error')
								.removeClass('has-success')
								.find('#text-error').remove();
							$("#form_inputan")[0].reset();
							$('#modalAdd').modal('hide');
							// $('#modalUpload').modal('show');
						} else {
							$.each(data['messages'], function(key, value) {
								var element = $('#' + key);
								element.closest('div.form-group')
									.removeClass('has-error')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')
									.find('#text-error')
									.remove();
								element.after(value);
							});
						}
						swal({
							html: true,
							timer: 2500,
							showConfirmButton: false,
							title: data['msg'],
							type: data['status']
						});
					}

				});
			});
	}

	function sendVerifikasi() {
		var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
		var csrf_hash = ''
		var url;

		url = '<?php echo base_url() ?>pengajuan_izin/izin/verifikasi';

		swal({
				title: "Apakah anda sudah yakin ?",
				type: "warning",
				showCancelButton: true,
				showLoaderOnConfirm: true,
				cancelButtonText: "Kembali",
				confirmButtonText: "Ya",
				closeOnConfirm: false
			},
			function() {
				$.ajax({
					url: url,
					method: 'POST',
					data: $('#form_inputanKA').serialize(),
					dataType: "JSON",
					success: function(resp) {
						data = resp.result
						csrf_hash = resp.csrf['token'];
						$('#form_inputanKA input[name=' + token_name + ']').val(csrf_hash);
						if (data['status'] == 'success') {
							updateAllTable();
							$('.form-group').removeClass('has-error')
								.removeClass('has-success')
								.find('#text-error').remove();
							$("#form_inputanKA")[0].reset();
							$('#modalVerifikasi').modal('hide');
							// $('#modalUpload').modal('show');
						} else {
							$.each(data['messages'], function(key, value) {
								var element = $('#' + key);
								element.closest('div.form-group')
									.removeClass('has-error')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')
									.find('#text-error')
									.remove();
								element.after(value);
							});
						}
						swal({
							html: true,
							timer: 2500,
							showConfirmButton: false,
							title: data['msg'],
							type: data['status']
						});
					}

				});
			});
	}
</script>
<?php $sso_user_data = $this->session->userdata('sso_user_data'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Pengajuan Izin Pegawai</h6>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="text-right">
							<button class="btn btn-success btn-xs" style="margin-right: 20px;" onclick="tambah()">
								<li class="fa fa-plus"></li> Add Data
							</button>
						</div>

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<?php if ($this->session->flashdata('notif')) { ?>
							<div class="alert alert-danger">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>!</strong> <?php echo $this->session->flashdata('notif'); ?>
							</div>
						<?php } else if ($this->session->flashdata('success')) { ?>
							<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>!</strong> <?php echo $this->session->flashdata('success'); ?>
							</div>
						<?php } ?>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display table-responsive table-stripted" id="myData">
									<thead>
										<tr class="bg-success">
											<th>
												<div style="font-size:9px">#</div>
											</th>
											<th>
												<div style="font-size:9px;width:90px;">Tools</div>
											</th>
											<th>
												<div style="font-size:9px">Nama Pegawai</div>
											</th>
											<th>
												<div style="font-size:9px">Lama Izin</div>
											</th>
											<th>
												<div style="font-size:9px">Tanggal Mulai</div>
											</th>
											<th>
												<div style="font-size:9px">Tanggal Berakhir</div>
											</th>
											<th>
												<div style="font-size:9px">Jadwal Off</div>
											</th>
											<th>
												<div style="font-size:9px">Konfirmasi KA Unit</div>
											</th>
											<th>
												<div style="font-size:9px">Ket</div>
											</th>
											<th>
												<div style="font-size:9px">Konfirmasi KA Bidang</div>
											</th>
											<th>
												<div style="font-size:9px">Ket</div>
											</th>
											<th>
												<div style="font-size:9px">Konfirmasi KA Bidang SDM</div>
											</th>
											<th>
												<div style="font-size:9px">Ket</div>
											</th>
											<th>
												<div style="font-size:9px">Bukti Izin</div>
											</th>
											<th>
												<div style="font-size:9px">Jenis Izin</div>
											</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End -->
<!-- Modal Add-->
<div id="modalAdd" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<li class="fa fa-list"></li> Form Pengajuan Izin
				</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<?php echo form_open('', array('id' => 'form_inputan', 'method' => 'post')); ?>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="id_izin" name="id_izin">
					<div class="col-md-12">
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Nama Pegawai<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<?php if ($getPegawai) { ?>
									<input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $getPegawai[0]->id_pegawai; ?>">
									<input type="text" name="" id="" class="form-control" value="<?= $getStaff[0]->nama; ?>" readonly>
								<?php } else {
									echo '<div style="color:red">Data Pegawai tidak ditemukan !</div>';
								} ?>
							</div>
						</div>
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Jenis Izin<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<select name="id_jenis_izin" id="id_jenis_izin" class="form-control" required>
									<option value="">Pilih Jenis Izin</option>
									<?php foreach ($getJenisIzin as $row) { ?>
										<option value="<?php echo $row->id_jenis_izin; ?>"><?php echo $row->jenis_izin . ' (' . $row->lama_izin . ' Hari )' ?></option>
									<?php } ?>
								</select>
								<!-- <input type="text" id="id_jenis_izin" name="id_jenis_izin" class="form-control" required> -->
							</div>
						</div>
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Tanggal Mulai<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control" required>
							</div>
						</div>
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Tanggal Berakhir<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control" required>
							</div>
						</div>
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Jadwal Off<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<input type="text" id="jadwal_off" name="jadwal_off" class="form-control">
							</div>
						</div>
						<?php if ($getStaff[0]->izin_akses == 'kaunit') { ?>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Konfirmasi KA Unit<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="acc_kaunit" name="acc_kaunit" class="form-control">

								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Keterangan KA Unit<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="ket_kaunit" name="ket_kaunit" class="form-control">
								</div>
							</div>
						<?php } ?>
						<!-- </div>
					<div class="col-md-6"> -->
						<?php if ($getStaff[0]->izin_akses == 'kabid') { ?>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Konfirmasi KA Bidang<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="acc_kabid" name="acc_kabid" class="form-control">
								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Keterangan KA Bidang<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="ket_kabid" name="ket_kabid" class="form-control">
								</div>
							</div>
						<?php } else if ($getStaff[0]->izin_akses == 'kabid_sdm') { ?>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Konfirmasi KA Bidang SDM<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="acc_kabid_sdm" name="acc_kabid_sdm" class="form-control" required>
								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Keterangan KA Bidang SDM<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="ket_sdm" name="ket_sdm" class="form-control" required>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				<button type="button" onclick="save()" class="btn btn-success btn-sm">Simpan</button>
			</div>
			<?php echo form_close() ?>
		</div>

	</div>
</div>
<!-- Modal Upload Gambar-->
<div id="modalUpload" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<li class="fa fa-list"></li> Upload/Ubah Bukti Izin
				</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<?php echo form_open('pengajuan_izin/izin/uploadData', array('id' => 'form_inputan1', 'method' => 'post', "enctype" => "multipart/form-data")); ?>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="id_izin" name="id_izin">
					<div class="col-md-12">
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Nama Pegawai<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<?php if ($getPegawai) { ?>
									<!-- <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $getPegawai[0]->id_pegawai; ?>"> -->
									<input type="text" name="" id="" class="form-control" value="<?= $getStaff[0]->nama; ?>" readonly>
								<?php } else {
									echo '<div style="color:red">Data Pegawai tidak ditemukan !</div>';
								} ?>
							</div>
						</div>
						<div class="field item form-group">
							<label class="col-form-label col-md-4 col-sm-3">Bukti Izin<span class="required">*</span></label>
							<div class="col-md-8 xdisplay_inputx form-group row ">
								<input type="file" id="bukti_izin" name="bukti_izin" class="form-control" required>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success btn-sm">Simpan</button>
			</div>
			<?php echo form_close() ?>
		</div>

	</div>
</div>
<!-- Modal Add-->
<div id="modalVerifikasi" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<li class="fa fa-list"></li> Form Pengajuan Izin
				</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<?php echo form_open('', array('id' => 'form_inputanKA', 'method' => 'post')); ?>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="id_izin" name="id_izin">
					<div class="col-md-12">
						<?php if ($getStaff[0]->tipe == 'kaunit') { ?>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Konfirmasi KA Unit<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<select name="acc_kaunit" id="acc_kaunit" class="form-control">
										<option value="0">Pilih</option>
										<option value="1">Terima Konfirmasi</option>
										<option value="2">Tolak Konfirmasi</option>
									</select>
								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Keterangan KA Unit<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<!-- <input type="text" id="ket_kaunit" name="ket_kaunit" class="form-control"> -->
									<textarea name="ket_kaunit" id="ket_kaunit" class="form-control"></textarea>
								</div>
							</div>
						<?php } else if ($getStaff[0]->tipe == 'kabid') { ?>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Konfirmasi KA Bidang<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<select name="acc_kabid" id="acc_kabid" class="form-control">
										<option value="0">Pilih</option>
										<option value="1">Terima Konfirmasi</option>
										<option value="2">Tolak Konfirmasi</option>
									</select>
								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Keterangan KA Bidang<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="ket_kabid" name="ket_kabid" class="form-control">
								</div>
							</div>
						<?php } else if ($getStaff[0]->tipe == 'apotik') { ?>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Konfirmasi KA Bidang SDM<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<select name="acc_kabid_sdm" id="acc_kabid_sdm" class="form-control">
										<option value="0">Pilih</option>
										<option value="1">Terima Konfirmasi</option>
										<option value="2">Tolak Konfirmasi</option>
									</select>
								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3">Keterangan KA Bidang SDM<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="text" id="ket_sdm" name="ket_sdm" class="form-control" required>
								</div>
							</div>
							<!-- <div class="field item form-group">
								<label class="col-form-label col-md-8 col-sm-3" id="label_lama_izin">Lama Izin <span class="required">*</span> <br><small style="color: green;font-size:10px">(Hanya dapat diisi untuk jenis izin (lainnya))</small></label>
								<div class="col-md-4 xdisplay_inputx form-group row ">
									<input type="text" id="lama_izin" name="lama_izin" class="form-control" required>
								</div>
							</div> -->

							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3" id="tgl_mulai_label">Tanggal Mulai<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control tgl_mulai" required>
								</div>
							</div>
							<div class="field item form-group">
								<label class="col-form-label col-md-4 col-sm-3" id="tgl_akhir_label">Tanggal Berakhir<span class="required">*</span></label>
								<div class="col-md-8 xdisplay_inputx form-group row ">
									<input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control tgl_akhir" required>
								</div>
							</div>

						<?php } ?>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				<button type="button" onclick="sendVerifikasi()" class="btn btn-success btn-sm">Simpan</button>
			</div>
			<?php echo form_close() ?>
		</div>

	</div>
</div>

<div class="seprator-block"></div>
<!--end of coba-->