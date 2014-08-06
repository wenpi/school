<?php

/**
 * 处理用户数据导入
 */
include_once('mysql.class.php') ;
// 要导入的数据库
$db1 = new MySQL( 'localhost' , 'root' , '123456' , 'ccc' ) ;
// 获取线上ccc的数据库
$db2 = new MySQL( '10.10.19.120' , 'root' , '123456' , 'testsystem' , 'latin1' ) ;
$data = $db2->getAll( "select * from users where status=1" ) ;
if( !empty( $data ) && is_array( $data ) )
{
	foreach( $data as $p )
	{
		$userId = ( int ) $p[ 'user_id' ] ; // 用户id
		$userName = trim( $p[ 'user_name' ] ) ; // 用户名
		$userPass = $p[ 'user_pw' ] ; //用户密码
		$realName = trim( $p[ 'real_name' ] ) ; // 用户名称
		$addDate = ( int ) $p[ 'add_date' ] ; // 添加时间
		// 添加基本信息
		insertUserBaseData( $userId , $userName , $realName , $userPass , 1 , $addDate ) ;
		// 添加关联详细信息
		insertUserDetailData( $userId ) ;
		// 添加关联公司信息
		insertUserCompanyData( $userId ) ;
		// 添加公司员工信息
		insertCompanyUserData( 1 , $userId ) ;
	}
}

// 添加用户基本信息
function insertUserBaseData( $userId , $userName , $realName , $userPass ,
	$status , $addTimeInt )
{
	global $db1 ;
	$realName = iconv( "gbk" , "utf-8" , $realName ) ;
	// 判断该用户ID是否存在
	if( $db1->getOne( "select count(*) from admin_users where user_id={$userId} and status!=4" ) < 1 )
	{
		$sql = "insert into admin_users (`user_id`,`user_name`,`real_name`,`user_pass`,`status`,`add_time_int`) values('{$userId}','{$userName}','{$realName}','{$userPass}',{$status},{$addTimeInt})" ;
		$db1->query( $sql ) ;
	}
}

// 添加用户详细信息
function insertUserDetailData( $userId )
{
	global $db1 ;
	if( $db1->getOne( "select count(*) from admin_user_detail where user_id={$userId}" ) < 1 )
	{
		$sql = "insert into admin_user_detail (`user_id`) values('{$userId}') " ;
		$db1->query( $sql ) ;
	}
}

// 添加用户公司信息
function insertUserCompanyData( $userId )
{
	global $db1 ;
	if( $db1->getOne( "select count(*) from admin_user_company where user_id={$userId}" ) < 1 )
	{
		$sql = "insert into admin_user_company (`user_id`) values('{$userId}') " ;
		$db1->query( $sql ) ;
	}
}

// 添加公司员工信息
function insertCompanyUserData( $companyId , $userId )
{
	global $db1 ;
	if( $db1->getOne( "select count(*) from admin_company_user where company_id={$companyId} and user_id={$userId}" ) < 1 )
	{
		$sql = "insert into admin_company_user (`company_id`,`user_id`) values('{$companyId}','{$userId}') " ;
		$db1->query( $sql ) ;
	}
}