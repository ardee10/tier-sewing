
$(document).ready(function() {
	
	/* Flash Data */
	if ($('.flash-data').length) {
		try {
			const flashDataElement = $('.flash-data').data('flashdata');
			const flashData = typeof flashDataElement === 'object' 
				? flashDataElement 
				: JSON.parse(flashDataElement || '{}');
			
			if (flashData.text) {
				Swal.fire({
					icon: flashData.type || 'info',
					title: flashData.type === 'success' ? 'Sukses!' : 'Oops...',
					text: flashData.text,
					timer: flashData.type === 'success' ? 2000 : 3000,
					showConfirmButton: flashData.type !== 'success',
					timerProgressBar: true
				});
			}
		} catch (e) {
			console.error('Error parsing flash data:', e);
		}
	}

	/* Hapus Data - pakai event delegation agar bekerja di DataTables */
	$(document).on('click', '.tombol-hapus', function (e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Data akan dihapus!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#e74c3c',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Ya, hapus!'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = href;
			}
		});
	});

	/* Data Table ERP Cell */
	$("#cellERP").DataTable({
		responsive: true,
		lengthChange: !0,
		autoWidth: !1,
		paging: !0,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 50, 100, "All"],
		],
	});
	/* Data Table ERP Cell */
	$("#table-flexim").DataTable({
		responsive: true,
		lengthChange: !0,
		autoWidth: !1,
		paging: !0,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 50, 100, "All"],
		],
	});
	/* Data Table ERP Cell */
	$("#targetERP").DataTable({
		responsive: true,
		lengthChange: !0,
		autoWidth: !1,
		paging: !0,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 50, 100, "All"],
		],
	});

	/* Layout */
		$("#table-layout").DataTable({
		responsive: true,
		lengthChange: !0,
		autoWidth: !1,
		paging: !0,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 50, 100, "All"],
		],
	});
	/* Critical Destination */
		$("#table-critical").DataTable({
		responsive: true,
		lengthChange: !0,
		autoWidth: !1,
		paging: !0,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 50, 100, "All"],
		],
	});


	/* Admin Model */
	$('#table-model').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Admin/ajax_ModelServerside',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});
	/* Kaizen Data */
	$('#table-kaizen').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Kaizen/ajax_KaizenServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});
	/* Defect Data */
	$('#table-defect').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Defect/ajax_DefectServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});
	/* MP Data */
	$('#table-mp').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Manpower/ajax_ManpowerServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});
	/* SixS */
	$('#table-sixs').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Sixs/ajax_SixsServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});
	/* Rft */
	$('#table-rft').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Rft/ajax_RftServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});
	/* Safety */
	$('#table-safety').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Safety/ajax_SafetyServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});

	/* Cot */
	$('#table-cot').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: base + 'Cot/ajax_CotServerSide',
			type: 'POST'
		},
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		]
	});

	

});

var options = {
		series: [{
			name: 'OUTPUT',
			type: 'column',
			data: []
		}, ],
		chart: {
			height: 150,
			type: 'line',
			toolbar: {
				show: true
			},
			events: {
				click: function(event, chartContext, config) {
					$('#kelompok_dt').val('')
					$('#remark_dt').val('')
					let index = config.dataPointIndex;
					let output_jam = config['config']['series'][0]['data'][parseFloat(index)].y;
					let target_cell = $('#textTargetEolr').text()
					let kode_jam = config.config.series[0].data[index].x
					let item = ''
					let no = 1
					let base = $('#base').val()
					let building = $('#factoryFilterHome').val()
					let cell = $('#cellFilterHome').val()
					let tgl = $('#dateFilterHome').val()
					let lost = target_cell - output_jam
					let targetPermenit = parseFloat(target_cell / 60).toFixed(0)
					let dt = parseFloat(lost / targetPermenit).toFixed(0)
					// let dt = (target_cell == '120') ? (lost / 2) : lost

					$.ajax({
							url: base + 'home/ajaxDowntimeLevel1/' + cell + '/' + tgl,
							type: 'get',
							dataType: 'json',
						})
						.done(function(data) {

							// console.log(data);
							try {
								$('#kode_jam').text(kode_jam)
								$('#text_kode_jam').val(kode_jam)
								$('#text_menit_jam').val(dt)
								$('#text_lost_dt').val(lost)

								item += '<table id="table-dt" class="table table-bordered table-striped">';
								item += '<tr class="bg-info">';
								item += '<th width="18%">KODE JAM</th>';
								item += '<th>MENIT</th>';
								item += '<th>LOST</th>';
								item += '<th>REMARK</th>';
								item += '</tr>';

								for (var i = 0; i < data.length; i++) {
									item += '<tr>';
									item += '<td>' + data[i].kode_jam + '</td>';
									item += '<td class="text-center">' + data[i].menit_dt + '</td>';
									item += '<td class="text-center">' + data[i].lost_dt + '</td>';
									item += '<td class="text-center">' + data[i].remark + '</td>';
									item += '</tr>';
								}
								item += '</table>';

								$('.app-table').html(item)
								$('#modalDowntime').modal('show')
							} catch (e) {}
						})
						.fail(function() {
							console.log("error ajax DT");
						})
				}
			},
		},
		stroke: {
			width: [0, 4, 4]
		},
		dataLabels: {
			enabled: true,
			offsetY: -20,
			style: {
				fontSize: '14px',
				colors: ["#000000"]
			}
		},
		xaxis: {
			type: 'text'
		},
		yaxis: [{
			title: {
				text: 'EOLR',
			},
		}, ],
	};
	
	var chart = new ApexCharts(document.querySelector("#chart"), options);
	chart.render();
