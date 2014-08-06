<?php

defined( 'PATH_ROOT' ) or die( 'Access Denied.' ) ;

/**
 * Admin模块
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class AdminModel
{

	/**
	 * 单例
	 * @var type
	 */
	private static $_singletonObject = null ;
	private $_admin ;

	private function __construct()
	{
		$this->_admin = new Data_Admin() ;
	}

	/**
	 * 实例化
	 * @return AdminModel
	 */
	public static function getInstance()
	{
		$className = __CLASS__ ;

		if( !isset( self::$_singletonObject [ $className ] ) || !self::$_singletonObject [ $className ] )
		{
			self::$_singletonObject [ $className ] = new self () ;
		}

		return self::$_singletonObject [ $className ] ;
	}

	/**
	 * 判断是否登录
	 * @return type
	 */
	public function isUserLogin( $userId )
	{
		return $this->_admin->isUserLogin( $userId ) ;
	}

	/**
	 *
	 * @param string $userName
	 * @param string $userPass
	 * @param string $where
	 * @return type
	 */
	public function getUserInfoByWhere( $userName , $userPass , $where = "" )
	{
		return $this->_admin->getUserInfoByWhere( $userName , $userPass , $where ) ;
	}

	/**
	 * 更新用户登录状态
	 * @param type $userId
	 * @param type $loginStatus
	 * @param type $loginTime
	 * @param type $logoutTime
	 * @return int
	 */
	public function updateUserLoginStatus( $userId , $loginStatus , $loginTime = 0 , $logoutTime = 0 )
	{
		return $this->_admin->updateUserLoginStatus( $userId ,$loginStatus ,$loginTime ,$logoutTime );
	}

	/**
	 * 判断是不是系统管理员
	 * @return type
	 */
	public function checkRole( $userId )
	{
		return $this->_admin->checkRole( $userId ) ;
	}

	/**
	 * 获取非管理员下的所有角色
	 * @return type
	 */
	public function getRole( $userId )
	{
		return $this->_admin->getRole( $userId ) ;
	}

	public function getRight( $userId )
	{
		return $this->_admin->getRight( $userId ) ;
	}

	/**
	 * 通过用户ID来获取所在组别
	 * @param type $userId
	 */
	public function getGroup( $userId )
	{
		return $this->_admin->getGroup( $userId );
	}

	/**
	 *
	 * @param type $action
	 * @param type $sessid
	 * @param type $authToken
	 * @param type $authUrl
	 * @return string
	 */
	public function auth( $action , $sessid , $authToken , $authUrl )
	{
		$result = "" ;
		$time = time() ;
		$token = md5( $authToken . $time ) ;

		if( is_array( $authUrl ) )
		{
			foreach( $authUrl as $val )
			{
				$result .= "<script type=\"text/javascript\" src=\"http://" . $val . "/sso.php?action=" . $action . "&sid=" . $sessid . "&t=" . $time . "&tt=" . $token . "&token=" . $authToken . "\"></script>";
			}
		}
		                
		return $result ;
	}

}