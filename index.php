<!DOCTYPE html>
<html>
<head>
	<title>Index Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#editStudentdiv').hide();

			getStudentList();

			function getStudentList(){
				$.get('studentlist.json', function(response){
					if (response) {
						console.log(typeof(response));
						// object
						// var studentObjArray = response;

						// string
						var studentObjArray = JSON.parse(response);

						var html =''; var j=1;

						$.each(studentObjArray, function(i,v){

							html += `<tr>
							<td>${j++}</td>
							<td>${v.name}</td>
							<td>${v.gender}</td>
							<td>${v.email}</td>
							<td>
							<button class="btn btn-outline-primary detail" data-id="${i}">
							<i class="fas fa-info-circle"></i>
							</button>

							<button class="btn btn-outline-warning edit"data-id="${i}">
							<i class="fas fa-edit"></i>
							</button>

							<button class="btn btn-outline-danger delete" data-id="${i}">
							<i class="fas fa-trash-alt"></i>
							</button>

							</td>
							</tr>`;
						});

						$('tbody').html(html);

					}
				});
			};

			$('tbody').on('click','.detail',function(){

				var id = $(this).data('id');

				// console.log(id);

				$.get('studentlist.json', function(response){
					console.log(response);

					if (response) {
						var studentObjArray = JSON.parse(response);

						var name = studentObjArray[id].name;
						var email = studentObjArray[id].email;
						var address = studentObjArray[id].address;
						var gender = studentObjArray[id].gender;
						var profile = studentObjArray[id].profile;

						$("#detail_name").text(name);
						$("#detail_email").text(email);
						$("#detail_address").text(address);
						$("#detail_gender").text(gender);

						// img
						$("#detail_photo").attr('src',profile);
						$("#detailModal").modal("show");
					}
				});

			});

			$('tbody').on('click','.edit',function(){

				var id = $(this).data('id');

				// console.log(id);

				$.get('studentlist.json', function(response){
					console.log(response);

					if (response) {
						var studentObjArray = JSON.parse(response);

						var name = studentObjArray[id].name;
						var email = studentObjArray[id].email;
						var address = studentObjArray[id].address;
						var gender = studentObjArray[id].gender;
						var profile = studentObjArray[id].profile;

						$("#edit_name").val(name);
						$("#edit_email").val(email);
						$("#edit_address").val(address);
						// $("#edit_gender").val(gender);

						if (gender == "Male") {
							$('#edit_male').attr('checked','checked');
						} else{

							$('#edit_female').attr('checked','checked');

						}

						// img
						$("#edit_photo").attr('src',profile);
						$('#edit_id').val(id);
						$('#edit_oldprofile').val(profile);
						

						$("#editStudentdiv").show();
						$("#create").hide();
						// $("#detailModal").modal("show");
					}
				});

			});

			$("tbody").on('click', '.delete', function(){

				var id = $(this).data('id');

				var ans = confirm('Are you sure want to delete?');

				if (ans) {
					$.post(
						'deletestudent.php', {id:id},
						function(data){
							getStudentList();
						}
						)
				}

			})

		});
	</script>
	<div class="container" id="create">
		<h1 style="text-align: center;">Add New Student</h1>
		<div class="row">
			<div class="col-lg-2"></div>

			<div class="col-lg-8">
				<form action="addstudent.php" method="POST" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="profile" class="col-sm-2 col-form-label">Profile</label>
						<div class="col-sm-10">
							<input type="file" name="profile" class="form-control-file" id="profile" placeholder="" >
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required="">
						</div> 
					</div>

					<div class="form-group row">
						<label for="mail" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required="">
						</div>
					</div>

					<div class="form-group row">
						<label for="gender" class="col-sm-2 col-form-label">Gender</label>
						<div class="col-sm-10">
							<div class="form-check">
								<input type="radio" class="form-check-input" id="gender" name="gender" value="male" required="">
								<label class="form-check-lable" for="Male">Male</label>
							</div>

							<div class="form-check">
								<input type="radio" class="form-check-input" id="gender" name="gender" value="Female" required="">
								<label class="form-check-lable" for="female">Female</label>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="address" class="col-sm-2 col-form-label">Address</label>
						<div class="col-sm-10">
							<textarea type="text" class="form-control" name="address" id="address" required="required"></textarea>
						</div>
					</div>

					<button type="submit" class="btn btn-primary" id="save">SAVE</button>

				</form>
			</div>
		</div>
	</div>

	<!-- <div class="container" id="editStudentdiv">
		<h1 style="text-align: center;">Edit Existing Student</h1>
		<div class="row">
			<div class="col-lg-2"></div>

			<div class="col-lg-8">
				<form>
				  <div class="form-group row">
				    <label for="profile" class="col-sm-2 col-form-label">Profile</label>
				    <div class="col-sm-10">
				    	<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Old Profile</a>
						  </li>

						  <li class="nav-item">
						    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">New Profile</a>
						  </li>
					</ul>




					<div class="tab-content" id="myTabContent">
					  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					  	
					  	<form>
					  		<div class="form-group row">
							    <label for="profile" class="col-sm-2 col-form-label"></label>
							    <div class="col-sm-10">
							      <input type="file" class="form-control-file" id="profile" placeholder="" required="">
							    </div>
							</div>

					  	</form>

					  </div>
					  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					  	<form>
					  		<div class="form-group row">
							    <label for="profile" class="col-sm-2 col-form-label">Profile</label>
							    <div class="col-sm-10">
							      <input type="file" class="form-control-file" id="profile" placeholder="" required="">
							    </div>
							 </div>
					  	</form>
					  </div>
					</div>



				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="name" class="col-sm-2 col-form-label">Name</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="name" placeholder="Enter Name" required="">
				    </div> 
				  </div>

				  <div class="form-group row">
				    <label for="mail" class="col-sm-2 col-form-label">Email</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="email" placeholder="Enter Email" required="">
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="gender" class="col-sm-2 col-form-label">Gender</label>
				    <div class="col-sm-10">
				    	<div class="form-check">
				      		<input type="radio" class="form-check-input" id="gender" name="gender" value="male" required="">
				      		<label class="form-check-lable" for="male">Male</label>
				     	</div>

				     	<div class="form-check">
				      		<input type="radio" class="form-check-input" id="gender" name="gender" value="male" required="">
				      		<label class="form-check-lable" for="female">Female</label>
				     	</div>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="address" class="col-sm-2 col-form-label">Address</label>
				    <div class="col-sm-10">
				      <textarea type="text" class="form-control" name="address" id="address" required="required"></textarea>
				    </div>
				  </div>

				  <button type="button" class="btn btn-primary" id="upd">UPDATE</button>

				</form>
			</div>
		</div>
	</div> -->
	<div class="row" id="editStudentdiv" style="margin-top: 2%;">
		<div class="col-lg-2"></div>
		<div class="col-lg-8" >
			<h1 class="text-center">Add Existing Student</h1>
			<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="oldprofile-tab" data-toggle="tab" href="#oldprofile" role="tab" aria-controls="oldprofile" aria-selected="true">Old Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="newprofile-tab" data-toggle="tab" href="#newprofile" role="tab" aria-controls="newprofile" aria-selected="false">New Profile</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<!-- Old Profile -->
				<div class="tab-pane fade show active" id="oldprofile" role="tabpanel" aria-labelledby="oldprofile-tab">
					<form style="margin-top: 5%;" mehod="POST" enctype="multipart/form-data">

						<input type="hidden" name="edit_id" id="edit_id">
						<input type="hidden" name="edit_oldprofile" id="edit_oldprofile">
						
						<div class="form-group row">
							<label for="edit_photo" class="col-lg-2 col-form-label">Profile</label>
							<div class="col-lg-10">  
								<img id="edit_photo" class="img-fluid" width="300px" height="400px">
							</div>
						</div>
						
						<div class="form-group row">
							<label for="edit_name" class="col-lg-2 col-form-label">Name</label>
							<div class="col-lg-10">  
								<input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Enter Name">
							</div>
						</div>
						
						<div class="form-group row">
							<label for="edit_email" class="col-lg-2 col-form-label">Email</label>
							<div class="col-lg-10">  
								<input type="email" class="form-control" id="edit_email" name="edit_email" placeholder="Enter Email">
							</div>
						</div>
						
						<div class="form-group row">
							<label for="edit_gender" class="col-lg-2 col-form-label">Gender</label>
							<div class="col-lg-10">  
								<div class="form-check">
									<input class="form-check-input" type="radio" name="edit_gender" id="edit_male" value="male" checked>
									<label class="form-check-label" for="emale">
										Male
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="edit_gender" id="edit_female" value="female">
									<label class="form-check-label" for="efemale">
										Female
									</label>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label for="edit_address" class="col-lg-2 col-form-label">Address</label>
							<div class="col-lg-10">  
								<textarea class="form-control" id="edit_address" name="edit_address" rows="3"></textarea>
							</div>
						</div>

						<button type="submit" class="btn btn-primary mb-2">Save</button>

					</form>
				</div>
				<!-- New Profile -->
				<div class="tab-pane fade show" id="newprofile" role="tabpanel" aria-labelledby="newprofile-tab">
					<form style="margin-top: 5%;" action="updatestudent.php" method="POST" enctype="multipart/form-data">
						
						<div class="form-group row">
							<label for="uprofile" class="col-lg-2 col-form-label">Profile</label>
							<div class="col-lg-10">  
								<input type="file" name="edit_newprofile" class="form-control-file" id="uprofile">
							</div>
						</div>
						
						<div class="form-group row">
							<label for="uname" class="col-lg-2 col-form-label">Name</label>
							<div class="col-lg-10">  
								<input type="text" name="edit_name" class="form-control" id="uname" placeholder="Enter Name">
							</div>
						</div>
						
						<div class="form-group row">
							<label for="uemail" class="col-lg-2 col-form-label">Email</label>
							<div class="col-lg-10">  
								<input type="email" name="edit_email" class="form-control" id="uemail" placeholder="Enter Email">
							</div>
						</div>
						
						<div class="form-group row" mar>
							<label for="ugender" class="col-lg-2 col-form-label">Gender</label>
							<div class="col-lg-10">  
								<div class="form-check">
									<input class="form-check-input" type="radio" name="edit_gender" id="umale" value="male" checked>
									<label class="form-check-label" for="umale">
										Male
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="edit_gender" id="ufemale" value="female">
									<label class="form-check-label" for="ufemale">
										Female
									</label>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label for="uaddress" class="col-lg-2 col-form-label">Address</label>
							<div class="col-lg-10">  
								<textarea class="form-control" name="edit_address" id="uaddress" rows="3"></textarea>
							</div>
						</div>

						<button type="submit" class="btn btn-primary mb-2">Update</button>

					</form>
				</div>

			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Email</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	<!-- Modal box -->



	<!-- Modal -->
	<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<div class="col-4">
								<img id="detail_photo" class="img-fluid">
							</div>
							<div class="col-8">
								<h1 id="detail_name"></h1>
								<p id="detail_gender"></p>
								<p id="detail_email"></p>
								<p id="detail_address"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


</body>
</html>