<?php

  $tbl = 'categories';
  $id = $id;

  $editurl = url('admin/categories/'.$id.'/edit');
  $editButton = '<a type="" style="text-decoration: none;" title="Edit" href="' . $editurl . '"><i class="fa fa-edit"></i>Edit</a>';
  $deleteButton = '<a  style="text-decoration: none;" data-title ="Confirmation" data-toggle="tooltip" data-placement="top" title="Delete Record"  onclick="hardDelete('.$id.')" href="javascript:void(0)" data-original-title="Delet"><i class="fa fa-trash"></i>Delete</a>';
?>


<div class="">
    <div class="btn-group">
      <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu" style="margin: 0px 0 0;">
          <li><?php echo $editButton; ?></li> 
          <li><?php echo $deleteButton; ?></li> 
        </ul>
    </div>
  </div>
