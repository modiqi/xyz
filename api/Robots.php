<?php

namespace Api;


class Robots
{
	// get_option('xyz-robots')
    function save(\WP_REST_Request $request)
    {
        //生成robots
        file_put_contents(ABSPATH . '/robots.txt', $request->get_param('robots'));
	
	
	    return [ 'code'  => 200, 'msg'   => 'success', 'data'  => $request->get_param('robots')];
    }
    

}