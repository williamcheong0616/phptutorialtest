<?php

	//make sue the user has access
	if(!logged_in() || user('id') != $_POST['id'])
	{
		$info['errors']['firstname'] = "You dont have permission to delete this profile";
	} 

	if(empty($info['errors']) && $row)
	{
		//delete row
		$arr = [];
		$arr['id'] = $id;
		
		db_query("delete from users where id = :id limit 1",$arr);

		//delete image
		if(file_exists($row['image']))
		{
			unlink($row['image']);
		}
 
		$info['success'] 	= true;

        //logout user
    if(!empty($_SESSION['USER'])) {
        unset($_SESSION['USER']);
    
        redirect('home');
        exit();
    }

	}

        
   