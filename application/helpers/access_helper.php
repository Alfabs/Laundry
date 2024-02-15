<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access_helper {

    public static function check_admin_access()
    {
        $CI = &get_instance();
        $user_role = $CI->session->userdata('role');

        if ($user_role !== 'admin') {
            // Redirect atau tindakan lain jika peran pengguna bukan admin
            redirect('blocked/');
		}
    }

	public static function check_kasir_access()
    {
        $CI = &get_instance();
        $user_role = $CI->session->userdata('role');

        if ($user_role !== 'kasir') {
            // Redirect atau tindakan lain jika peran pengguna bukan admin
            redirect('blocked/');
		}
    }

	public static function check_owner_access()
    {
        $CI = &get_instance();
        $user_role = $CI->session->userdata('role');

        if ($user_role !== 'owner') {
            // Redirect atau tindakan lain jika peran pengguna bukan admin
            redirect('blocked/');
		}
    }

	


}
