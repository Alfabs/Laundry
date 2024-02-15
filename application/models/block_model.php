<?php

class block_model extends CI_model {

	public function denied($username)
	{
		if($this->session->userdata($username)){
			redirect('user');
		}
	}

}
