<?php 


if(!empty($_POST['data_type']))
{
	$info['data_type'] 	= $_POST['data_type'];
	$info['errors'] 	= [];
	$info['success'] 	= false;

	if($_POST['data_type'] == "profile-edit")
	{

		$id = user('id');

		$row = db_query("select * from users where id = :id limit 1",['id'=>$id]);

		var_dump($id);
		if($row)
		{
			$row = $row[0];
		}
		require 'includes/profile-edit-controller.php';
	}else
	if($_POST['data_type'] == "profile-delete")
	{

		$id = user('id');

		$row = db_query("select * from users where id = :id limit 1",['id'=>$id]);
		if($row)
		{
			$row = $row[0];
		}
		require 'includes/profile-delete.php';
	}else


	echo json_encode($info);
}

