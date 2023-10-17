@extends('layouts.app')

@section('content')
<div class="container table-responsive">
<div class="mb-2">
        <button class="btn btn-success" id="print-table-button">Download <i class="fas fa-download"></i></button>
       <i class="fa fa-angle-double-up" style="font-size:36px" onclick="scrollToTop()" id="scroll-to-top-btn" title="Go to top"></i>

    </div>
    <table class="table table-bordered" id="members-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Date of Birth</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="edit-member-modal" tabindex="-1" role="dialog" aria-labelledby="editMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>

            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-member-modal" tabindex="-1" role="dialog" aria-labelledby="deleteMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMemberModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this member?
            </div>
        </div>
    </div>
</div>
<style>
    #scroll-to-top-btn {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  font-size: 10px;
  outline: none;
  color: white;
  cursor: pointer;
  padding: 15px;
}

</style>
<script>
function scrollToTop() {
    // alert('upr kr deu kya')
  document.body.scrollTop = 0; 
  document.documentElement.scrollTop = 0; 
}

window.onscroll = function() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("scroll-to-top-btn").style.display = "block";
  } else {
    document.getElementById("scroll-to-top-btn").style.display = "none";
  }
}

$(document).ready(function() {
    var table = $('#members-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("members.index") }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'age', name: 'age' },
            { data: 'date_of_birth', name: 'date_of_birth' },
            { 
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                        <button class="btn btn-outline-primary edit-member"data-toggle="modal" data-target="#edit-member-modal" data-id="${full.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline-danger delete-member" data-id="${full.id}"><i class="fas fa-trash-alt"></i></button>

                    `; 
                }
            }
        ]
    });

    $('#members-table').on('click', '.edit-member', function () {
        var memberId = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: `members/${memberId}/edit`,
            success: function (data) {
                $('#edit-member-modal .modal-body').html(data);
                $('#edit-member-modal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

   
});
$('#members-table').on('click', '.delete-member', function () {
    var memberId = $(this).data('id');
    
    // Ask for confirmation
    if (window.confirm('Are you sure you want to delete this member?')) {
        $.ajax({
            type: 'DELETE',
            url: `members/${memberId}`,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function (data) {
                $('#members-table').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        
    }
   
});
</script>
<script>
     $('#print-table-button').on('click', function () {
        // Print the table logic here
        window.print();
    });
    </script>
@endsection
