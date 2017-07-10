<?php
if (! defined('BASEPATH'))
  exit('No direct script access allowed');
$config = array (
  'menu' => array (
    '菜谱管理' => array (
      'code' => 'menus',
      'class' => 'explode',
      'list' => array (
        array (
          '/foods',
          '菜品管理'
        ),
        array (
          '/foodstype',
          '菜品分类管理'
        ),
        array (
          '/combo',
          '套餐管理'
        ),
        array (
          '/combo/cate',
          '套餐分类'
        )
      )
    ),
    '人员管理' => array (
      'code' => 'menus',
      'class' => 'explode',
      'list' => array (
        array (
          '/express',
          '配送员管理'
        )
      )
    ),
    '会员管理' => array (
      'code' => 'user_manage',
      'class' => 'explode',
      'list' => array (
        array (
          '/user',
          '会员列表'
        ),
        array (
          '/comment',
          '吐槽列表'
        )
      )
    ),
    '资讯管理' => array (
      'code' => 'news_manage',
      'class' => 'explode',
      'list' => array (
        array (
          '/news',
          '资讯列表'
        ),
        array (
          '/news/class_list',
          '资讯类型'
        )
      )
    ),
    
    '手工位管理' => array (
      'code' => 'shougongwei',
      'class' => 'explode',
      'list' => array (
        array (
          '/manualclass',
          '手工位名称'
        ),
        array (
          '/manual',
          '手工位内容'
        )
      )
    ),
    '订单管理' => array (
      'code' => 'orders',
      'class' => 'explode',
      'list' => array (
        array (
          '/order',
          '订单管理'
        )
      )
    ),
    '管理员管理' => array (
      'code' => 'admin_user_manage',
      'class' => 'explode',
      'list' => array (
        array (
          '/admin',
          '管理员列表'
        ),
        array (
          '/admingroup',
          '角色管理'
        ),
        array (
          '/adminspurview',
          '权限管理'
        )
      )
    ),
    '操作日志' => array (
      'code' => 'operate_log',
      'class' => 'explode',
      'list' => array (
        array (
          '/operatelog',
          '登录操作日志'
        )
      )
    ),
    '系统管理' => array (
      'code' => 'system_manage',
      'class' => 'explode',
      'list' => array (
        array (
          '/configes',
          '系统配置'
        ),
        array (
          '/version',
          '静态资源版本号更新'
        )
      )
    )
  )
);
