<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *CI框架分页类配置文件
 */
$config = array(
        'config' => array(
                'first_link' => '<<',
                'last_link' => '>>',
                'prev_link' => '<',
                'next_link' => '>',
                'use_page_numbers' => TRUE,
                'cur_tag_open' => '<a class="page_num act">',
                'cur_tag_close' => '</a>',
                'page_query_string' => TRUE,
                //'display_pages'=>FALSE,
                'attributes' => array('class' => 'page_num','rel'=>FALSE),
                'per_page' => 12// 每页条目数
        ),
        'config_project' => array(
                'first_link' => '<<',
                'last_link' => '>>',
                'prev_link' => '<',
                'next_link' => '>',
                'use_page_numbers' => TRUE,
                'cur_tag_open' => '<a class="page_num act">',
                'cur_tag_close' => '</a>',
                'page_query_string' => FALSE,
                'prefix' => '',
                'use_global_url_suffix' => TRUE,
                'attributes' => array('class' => 'page_num','rel'=>FALSE),
                'per_page' =>5// 每页条目数
 
        ),
        //nengfu@gz-zc.cn
        'config_log' => array(
            'first_link' => '<<',
            'last_link' => '>>',
            'prev_link' => '<',
            'next_link' => '>',
            'use_page_numbers' => TRUE,
            'prev_tag_open' => '<li class="paginItem">',
            'prev_tag_close' => '</li>',
            'next_tag_open' => '<li class="paginItem">',
            'next_tag_close' => '</li>',
            'first_tag_open' => '<li class="paginItem">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li class="paginItem">',
            'last_tag_close' => '</li>',
            'num_tag_open' => '<li class="paginItem">',
            'num_tag_close' => '</li>',
            'cur_tag_open' => ' <li class="paginItem current"><a >', //当前也标签
            'cur_tag_close' => '</a></li>',
            'page_query_string' => TRUE,
            'attributes' => array('class' => 'paginItem','rel'=>FALSE),
            'per_page' =>15// 每页条目数

        )
        
);
