<!DOCTYPE html>
<html>
<head>
	<title>Import Excel</title>

	<!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.select.min.css') }}">
</head>
<body>
	<div class="page-wrapper">
        <div class="container-fluid">
        	<div class="row">
				<div class="col-lg-12" style="margin-bottom:12px;">
			        <div class="card">
			            <div class="card-header">Import File Excel</div>
						<div class="card-body">
							<a href="javascript:void(0)" class="btn btn-success" id="new_excel"><span class="btn-label"><i class="ti-plus"></i></span> Add New</a>
								
							<hr >
							<div class="table-responsive">
								<table class="table table-hover table-striped table-bordered color-table info-table" id="data_table_main_hdr" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>#</th>
											<th>File Name</th>
											<th>Upload Date</th>
											<!-- <th>User Upload</th>
											<th>Actions</th> -->
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

						<div id="modal_import_excel" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					    	<div class="modal-dialog modal-lg">
					    		<div class="modal-content">
					    			<div class="modal-header">
										<h4 class="modal-title" id="modal_title_scan_hdr"></h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									</div>
									<div class="modal-body" style="overflow: hidden;">
										<form id="modal_form_scan_hdr" class="form-horizontal">
											<input type="hidden" name="state" id="state">											
											<input type="hidden" name="filename" id="filename">
											{{ csrf_field() }}

										    <div class="row">
										        <div class="col-md-12">
												    <div class="form-group">
							                            <label>File upload</label>
							                            <input type="file" class="form-control" id="exampleInputFile" name="exampleInputFile" aria-describedby="fileHelp">
							                        </div>
							                    </div>
							                </div>
										    <div class="row">
										    	<div class="col-md-12">
										    		<div class="form-group">
										    			<div class="input-group">
										    				<button type="button" class="btn btn-warning" id="import_upload_hdr" >
					                        					<span class="btn-label"><i class="ti-import"></i></span> Import
					                    					</button>
					                    				</div>
					                    			</div>
					                    		</div>
					                    	</div>
										    <div class="row">
										        <div class="col-md-12">
												    <div class="table-responsive">
														<table class="table table-hover table-striped table-bordered color-table info-table" id="data_table_main_dtl" cellspacing="0" width="100%">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>#</th>
																	<th>Nik</th>
																	<th>Nama</th>
																	<th>Tanggal</th>
																	<th>Status</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</form>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-info" id="save_import" >
					                        <span class="btn-label"><i class="ti-save"></i></span> Proses
					                    </button>
										<button type="button" class="btn btn-danger cancel_import" data-dismiss="modal">
											<span class="btn-label"><i class="ti-power-off "></i></span> Cancel
					                    </button>
					                </div>
					    		</div>
					    	</div>
					    </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>

    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    <script>
    	function list_data_hdr() {
	        $("#data_table_main_hdr").DataTable({
	            destroy:true,
	            processing: true,
	            serverSide: true,
	            ajax: {
	                url: "{{route('import.data.hdr')}}",
	                type: "get",	                
	            },
	            columns: [
	                { data: "id", name: "id", visible: false }, // 0
	                { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false }, // 1
	                { data: "file_name", name: "file_name", visible: true }, // 2
	                { data: "created_at", name: "created_at", visible: true }, // 3	                
	            ],
	            //      aligment left, right, center row dan coloumn
	            // order: [["0", "desc"]],
	            columnDefs: [
	                {
	                    className: "text-center",
	                    targets: [0, 1, 2, 3],
	                },
	                // {
	                //     className: "text-right",
	                //     targets: [ 8, 9, 10],
	                // },
	            ],
	            bAutoWidth: false,
	            responsive: true,
	        });
	        $("#data_table_main_hdr").css("cursor", "pointer");
	    }

    	function list_data_dtl(id_hdr) {
	        $("#data_table_main_dtl").DataTable({
	            destroy:true,
	            processing: true,
	            serverSide: true,
	            ajax: {
	                url: "{{route('import.data.dtl')}}",
	                type: "get",
	                data:{id_hdr:id_hdr},
	            },
	            columns: [
	                { data: "id", name: "id", visible: false }, // 0
	                { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false }, // 1
	                { data: "nik", name: "nik", visible: false }, // 2
	                { data: "nama", name: "nama", visible: true }, // 3
	                { data: "tanggal", name: "tanggal", visible: true }, // 4
	                { data: "status", name: "status", visible: true }, // 5	                
	            ],
	            //      aligment left, right, center row dan coloumn
	            // order: [["0", "desc"]],
	            columnDefs: [
	                {
	                    className: "text-center",
	                    targets: [0, 1, 2, 3, 4, 5],
	                },
	                // {
	                //     className: "text-right",
	                //     targets: [ 8, 9, 10],
	                // },
	            ],
	            bAutoWidth: false,
	            responsive: true,
	        });
	        $("#data_table_main_dtl").css("cursor", "pointer");
	    }

	    list_data_hdr();
    	$('#new_excel').click(function(event) {
    		list_data_dtl(0);
    		$('#modal_import_excel').modal('show');
    	});

    	$('#import_upload_hdr').click(function(e) {
    		var form = $('#modal_form_scan_hdr')[0];
			var formData = new FormData(form);
			// alert(formData);
			$.ajax({
	            type: "post",
	            url: "{{route('import.absensi')}}",
	            processData:false,
				contentType: false,
				data: formData,
	            success: function (response) {
	                for (var key in response) {
	                    var flag = response["success"];
	                    var message = response["message"];	                    
	                }

	                if ($.trim(flag) == "true") {	                    
	    				swal('Success!',message,{
				    		icon:'success',
				    		buttons:{
				    				confirm:{
				    					className:'btn btn-success'
				    				}
				    			
				    		}
				    	});
				    	list_data_dtl(0);
	                } else {
	                	swal('Error!',message,{
				    		icon:'warning',
				    		buttons:{
				    				confirm:{
				    					className:'btn btn-warning'
				    				}
				    			
				    		}
				    	});                    
	                }
	            },
	            error: function (xhr, status, error) {
	                var errorMessage = xhr.status + ": " + xhr.statusText;
	                swal('Error!',errorMessage,{
				    		icon:'danger',
				    		buttons:{
				    				confirm:{
				    					className:'btn btn-danger'
				    				}
				    			
				    		}
				    });                
	            },
	        });
    	});

    	$('#save_import').click(function(event) {
    		file=$('#exampleInputFile').val();
			filename=file.replace('C:\\fakepath\\','');
			$('#filename').val(filename);

			$.ajax({
	            type: "get",
	            url: "{{route('import.store')}}",
	            data: $("#modal_form_scan_hdr").serialize(),
	            success: function (response) {
	                for (var key in response) {
	                    var flag = response["success"];
	                    var message = response["message"];
	                    var id_hdr = response["id_hdr"];
	                }

	                if ($.trim(flag) == "true") {
	                    // var oTableHdr = $("#tbl_list_hdr").dataTable();
	                    // oTableHdr.fnDraw(false);
	                    // $('#sysid_hdr').val(id_hdr);
	                    list_data_dtl(id_hdr);
	    				swal('Success!',message,{
				    		icon:'success',
				    		buttons:{
				    				confirm:{
				    					className:'btn btn-success'
				    				}
				    			
				    		}
				    	});
	                } else {
	                	swal('Error!',message,{
				    		icon:'warning',
				    		buttons:{
				    				confirm:{
				    					className:'btn btn-warning'
				    				}
				    			
				    		}
				    	});                    
	                }
	            },
	            error: function (xhr, status, error) {
	                var errorMessage = xhr.status + ": " + xhr.statusText;
	                swal('Error!',errorMessage,{
				    		icon:'danger',
				    		buttons:{
				    				confirm:{
				    					className:'btn btn-danger'
				    				}
				    			
				    		}
				    });                
	            },
	        });
    	});
    </script>
</body>
</html>	